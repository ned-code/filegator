<?php


namespace Filegator\Services\Storage;


trait hasDescription
{
    protected $descriptionFile = "desc.txt";

    protected $descriptionHeaders = [
        'title',
        'desc'
    ];

    public function readDescriptionFile($path)
    {
        $description = [];

        $descFilePath = $path . '/' . $this->descriptionFile;

        if (!$this->fileExists($descFilePath))
            return [];

        $fileContents = $this->storage->read($this->applyPathPrefix($descFilePath));

        $lines = explode("\n", $fileContents);

        foreach ($lines as $line) {
            $fragments = explode(':', $line);

            if (in_array($fragments[0], $this->descriptionHeaders))
                $description[$fragments[0]] = str_replace($fragments[0] . ':', '', $line);
        }

        return $description;
    }
}