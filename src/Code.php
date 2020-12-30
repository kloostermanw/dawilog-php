<?php

namespace Dawilog;

use SplFileObject;

class Code
{
    /** @var SplFileObject */
    private $file;

    /** @var int */
    private $codeLength = 25;

    public function get(string $strFile, int $intLine): array
    {
        if (! file_exists($strFile)) {
            return [];
        }

        $this->file = new SplFileObject($strFile);

        $intStartLine =  floor($intLine - ($this->codeLength / 2));
        $intStartLine = ($intStartLine > 1) ? $intStartLine : 1;

        $intEndLine = $intStartLine + $this->codeLength;
        $max = $this->numberOfLines();
        $intEndLine = ($intEndLine > $max) ? $max : $intEndLine;

        $arrCode = [];

        for ($i = $intStartLine; $i <= $intEndLine; $i++) {
            $this->file->seek($i - 1);
            $arrCode[$i] = $this->file->current();
        }

        return $arrCode;
    }

    protected function numberOfLines(): int
    {
        $this->file->seek(PHP_INT_MAX);

        return $this->file->key() + 1;
    }
}
