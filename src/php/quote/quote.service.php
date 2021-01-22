<?php

require_once(__DIR__.'/quote.repository.php');
require_once(__DIR__.'/quote.model.php');

class QuoteService
{
    public static function addQuotation(string $company, string $telephone, string $reason, int $userId, array $cart) : ?int
    {
        $quoteId = QuoteRepository::insertOne($company, $telephone, $reason, $userId);

        if($quoteId)
        {
            $res = QuoteRepository::insertProductReleatedToQuote($quoteId, $cart);

            return $res ? $quoteId : -1;
        }

        return $quoteId;
    }
}
