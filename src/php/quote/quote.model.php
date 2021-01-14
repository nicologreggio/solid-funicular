<?php

class QuoteModel
{
    private int $id;
    private int $user;
    private string $reason;
    private string $company;
    private string $telephone;
    private array $products;

    public function __construct(int $id, string $reason, string $company, string $telephone, int $user)
    {
        $this->id = $id;
        $this->reason = $reason;
        $this->company = $company;
        $this->telephone = $telephone;
        $this->user = $user;
    }

    public static function instanceFromQuote($quote) : QuoteModel
    {
        return new QuoteModel($quote->_ID, $quote->_REASON, $quote->_COMPANY, $quote->_TELEPHONE, $quote->_USER);
    }

    public function getId() : int
    {
        return $this->id;
    }

    public function getReason() : string
    {
        return $this->reason;
    }

    public function getCompany() : string
    {
        return $this->company;
    }

    public function getTelephone() : string
    {
        return $this->telephone;
    }

    public function getUser() : int
    {
        return $this->user;
    }
}
