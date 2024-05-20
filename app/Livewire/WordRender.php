<?php

namespace App\Livewire;

use App\Models\Treatment;
use DOMDocument;
use DOMXPath;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Infolists\Contracts\HasInfolists;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Settings;

class WordRender extends Component implements HasForms, HasInfolists
{
    use InteractsWithForms;
    use InteractsWithInfolists;

    //mount
    public ?string $edufile;
    public function mount(Model $record)
    {
        $this->edufile = $record->edufile;
    }
    public function render()
    {
        $edufile = $this->edufile;
        //check if edufile is null
        if (!$edufile) {
            $content = 'Treatment education file has not been uploaded yet.';
        } else {
            //check if file is pdf or docx
            
                $content = $this->wordtoHTML($edufile);
        }


        return view('livewire.word-render',  compact('content'));
    }

    public function wordtoHTML($edufile)
    {
        try {
            $filePath = storage_path('app/public/' . $edufile);
            if (!file_exists($filePath)) {
                //redirect to previous url
                return redirect()->back()->with('error', 'File not found.');
            }
            // Load .docx file
            $phpWord = IOFactory::load($filePath);
    
            // Convert to HTML
            Settings::setOutputEscapingEnabled(true);
            $xmlWriter = IOFactory::createWriter($phpWord, 'HTML');
    
            // Save HTML to temp file
            $tempFile = tempnam(sys_get_temp_dir(), 'PHPWord');
            $xmlWriter->save($tempFile);
    
            // Read contents of temp file
            $content = file_get_contents($tempFile);
    
            // Load the content into a DOMDocument
            $doc = new DOMDocument();
            @$doc->loadHTML($content);
    
            // Create a new XPath object
            $xpath = new DOMXPath($doc);
    
            // Query all <style> elements
            $styleNodes = $xpath->query('//style');
    
            // Remove each <style> element
            foreach ($styleNodes as $styleNode) {
                $styleNode->parentNode->removeChild($styleNode);
            }
    
            // Query the <body> element
            $bodyNode = $xpath->query('//body')->item(0);
    
            // Save the inner HTML of the <body> element
            $content = '';
            foreach ($bodyNode->childNodes as $childNode) {
                $content .= $doc->saveHTML($childNode);
            }
    
            // Delete temp file
            unlink($tempFile);
    
            return $content;
        } catch (\Exception $e) {
            // Log the exception message
            Log::error('Error in wordtoHTML: ' . $e->getMessage());
    
            // Return a user-friendly error message
            return 'An error occurred while converting the Word document to HTML. Please try again later.';
        }
    }
  
}
