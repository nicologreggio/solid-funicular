<?php

require_once(__DIR__."/../../DBC.php");

class QuoteRepository
{
    public static function insertOne(string $company, string $telephone, string $reason, int $userId) : ?int
    {
        $stm = DBC::getInstance()->prepare("
            INSERT INTO `QUOTES`(`_TELEPHONE`, `_REASON`, `_COMPANY`, `_USER`) 
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

        $data = [];

        foreach($cart as $productId => $quantity)
        {
            $data[] = $quoteId;
            $data[] = $productId;
            $data[] = $quantity;
        }

        $res = $stm->execute($data);

        return $res;
    }
}
