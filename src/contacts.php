<?php

require_once './utils/utils.php';

echo fetchAndFillCategories(file_get_contents('./contacts/contacts.html'));
