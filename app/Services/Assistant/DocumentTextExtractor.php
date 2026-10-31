<?php

namespace App\Services\Assistant;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Process;
use RuntimeException;
use ZipArchive;

/**
 * Extracts plain text from uploaded TXT, DOCX and PDF files. The file is only
 * read, never executed; PDFs use the `pdftotext` tool when the server has it.
 */
class DocumentTextExtractor
{
    /**
     * @throws RuntimeException when the text cannot be extracted
     */
    public function extract(UploadedFile $file): string
    {
        $text = match (strtolower($file->getClientOriginalExtension())) {
            'txt' => (string) file_get_contents($file->getRealPath()),
            'docx' => $this->docx($file->getRealPath()),
            'pdf' => $this->pdf($file->getRealPath()),
            default => throw new RuntimeException('Unsupported file type.'),
        };

        $text = trim(preg_replace("/[ \t]+/u", ' ', str_replace("\r", '', $text)) ?? '');

        if (! mb_check_encoding($text, 'UTF-8') || $text === '') {
            throw new RuntimeException('No readable text was found in the file.');
        }

        return $text;
    }

    private function docx(string $path): string
    {
        $zip = new ZipArchive;

        if ($zip->open($path) !== true) {
            throw new RuntimeException('The DOCX file could not be opened.');
        }

        $xml = $zip->getFromName('word/document.xml');
        $zip->close();

        if ($xml === false) {
            throw new RuntimeException('The DOCX file has no document text.');
        }

        $xml = preg_replace('/<\/w:p>/', "\n\n", $xml) ?? $xml;

        return html_entity_decode(strip_tags($xml), ENT_QUOTES | ENT_XML1, 'UTF-8');
    }

    private function pdf(string $path): string
    {
        $result = Process::timeout(30)->run(['pdftotext', '-enc', 'UTF-8', '-layout', $path, '-']);

        if ($result->failed()) {
            throw new RuntimeException('PDF text extraction is not available on this server (install poppler-utils).');
        }

        return $result->output();
    }
}
