<?php
namespace App\Mail;

use App\Models\DocsData;
use Illuminate\Bus\Queueable;
use Illuminate\Http\UploadedFile;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UploadDocs extends Mailable
{
    use Queueable, SerializesModels;

    /*
     * Docs Data instance
     *
     * @var DocsData
     */
    public $data;
    /**
     * Create a new message instance.
     *
     * @param DocsData $data
     */
    public function __construct(DocsData $data)
    {
        $this->data = $data;
    }

    public function getName(UploadedFile $file, $name)
    {
        return $name . '_' . array_get($this->data, 'cid'). '.' . $file->extension();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        try {
            $passport = array_get($this->data, 'passport');
            $creditCardFront = array_get($this->data, 'creditCardFront');
            $creditCardBack = array_get($this->data, 'creditCardBack');
            $utilityBill = array_get($this->data, 'utilityBill');
            return $this->view('emails.docs')
                ->attach($passport, [
                    'as' => $this->getName($passport, 'passport')
                ])
                ->attach($creditCardFront, [
                    'as' => $this->getName($creditCardFront, 'creditCardFront')
                ])
                ->attach($creditCardBack, [
                    'as' => $this->getName($creditCardBack, 'creditCardBack')
                ])
                ->attach($utilityBill, [
                    'as' => $this->getName($utilityBill, 'utilityBill')
                ]);
        } catch (\Exception $exception) {
            return $this->view('emails.docs');
        }
    }
}
