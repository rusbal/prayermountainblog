<?php

namespace App\Http\Controllers;

use Auth;
use App\Name;

use App\Http\Requests;

class WordDocGenerator extends Controller
{
    private $phpWord;

    /**
     * Font variables
     */
    private $h1;
    private $h3;
    private $regular;

    public function __construct()
    {
        $this->middleware('auth');
        $this->phpWord = new \PhpOffice\PhpWord\PhpWord();

        $this->h1      = array('name' => 'Arial', 'size' => 20, 'color' => '800000', 'bold' => true);
        $this->h3      = array('name' => 'Arial', 'size' => 16, 'color' => '004080', 'bold' => true);
        $this->regular = array('name' => 'Arial', 'size' => 12);
    }

    public function __invoke()
    {
        $this->generateDocument();

        $savePath = $this->savePath('names-of-jesus');

        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($this->phpWord, 'Word2007');
        $objWriter->save($savePath);

        return redirect('/docs')->with('status', 'Newly added: ' . $savePath); 
    }

    /**
     * Private
     */
    private function generateDocument()
    {
        $names = Name::with('latestRevision')->get();
        $lineStyle = array('weight' => 1, 'width' => 1000, 'height' => 0, 'color' => 635552);

        foreach ($names as $name) {
            $rev = $name->latestRevision;

            $section = $this->phpWord->addSection();

            $section->addText( htmlspecialchars($name->order . '. ' . strtoupper($rev->name)), $this->h1);
            $section->addTextBreak(3);

            $section->addText( htmlspecialchars('Verse'), $this->h3);
            $section->addLine($lineStyle);
            $section->addText( htmlspecialchars($rev->verse), $this->regular);
            $section->addTextBreak(3);

            $section->addText( htmlspecialchars('Meaning & Function'), $this->h3);
            $section->addLine($lineStyle);
            $section->addText( htmlspecialchars($rev->meaning_function), $this->regular);
            $section->addTextBreak(3);

            $section->addText( htmlspecialchars('Identical Titles'), $this->h3);
            $section->addLine($lineStyle);
            $section->addText( htmlspecialchars($rev->identical_titles), $this->regular);
            $section->addTextBreak(3);

            $section->addText( htmlspecialchars('Significance for Believers'), $this->h3);
            $section->addLine($lineStyle);
            $section->addText( htmlspecialchars($rev->significance), $this->regular);
            $section->addTextBreak(3);

            $section->addText( htmlspecialchars('Our Responsibility'), $this->h3);
            $section->addLine($lineStyle);
            $section->addText( htmlspecialchars($rev->responsibility), $this->regular);
        }
    }

    private function savePath($name)
    {
        $publicDir = $this->setDirectory();
        $timestamp = time();
        $user      = Auth::user()->initials;

        return "{$publicDir}/{$user}-{$name}.{$timestamp}.docx";
    }

    private function setDirectory()
    {
        $publicDir = 'downloads/MSWord';

        @mkdir('downloads/MSWord', 0755, true);

        return $publicDir;
    }
}

