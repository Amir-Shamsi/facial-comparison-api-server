<?php


namespace App\Api;
use Symfony\Component\Validator\Constraints as Assert;


class FaceUploadApiModel
{
    /**
     * @Assert\NotBlank()
     */
    public $sourceFace;

    /**
     * @Assert\NotBlank()
     */
    public $targetFace;

    /**
     * @Assert\NotBlank()
     */
    private $secret;

    private $decodedSecret;

    public function setData()
    {
        $this->decodedSecret = base64_decode($this->secret);
    }

    public function getDecodedData(): ?string
    {
        return $this->decodedSecret;
    }
}