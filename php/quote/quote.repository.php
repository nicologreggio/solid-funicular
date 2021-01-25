<?php

require_once(__DIR__."/../../DBC.php");

class QuoteRepository
{
    public static function insertOne(string $company, string $telephone, string $reason, int $userId) : ?int
    {
        $stm = DBC::getInstance()->prepare("
            INSERT INTO `QUOTES`(`_COMPANY`, `_TELEPHONE`, `_REASON`,  `_USER`) 
            VALUES (?, ?, ?, ?)
        ");

        $res = $stm->execute([
            $company,
            $telephone,
            $reason,
            $userId,
        ]);

        return $res ? DBC::getInstance()->lastInsertId("QUOTES") : null;
    }
    
    public static function insertProductReleatedToQuote(int $quoteId, array $cart) : bool
    {
        $stm = DBC::getInstance()->prepare("
            INSERT INTO `QUOTE_PRODUCT` (`_QUOTE_ID`, `_PRODUCT_ID`, `_QUANTITY`) 
            VALUES (?, ?, ?)
        ");

        $res = true;

        foreach($cart as $productId => $quantity)
        {
            $res &= $stm->execute([$quoteId, $productId, $quantity ?? 1]);
        }

        return $res;
    }
}
