<?php

function getCategories(PDO $pdo) {
    $query = $pdo->prepare("SELECT * FROM categories");
    $query->execute();
    return $query->fetchall(PDO::FETCH_ASSOC);
}

function getCategory(PDO $pdo, $categoryCode) {
    $query = $pdo->prepare("SELECT * FROM categories WHERE categoryCode = :categoryCode");
    $query->bindParam(':categoryCode', $categoryCode, PDO::PARAM_STR);
    $query->execute();
    return $query->fetch();
}

function getProductById(PDO $pdo, int $id) {
    $query = $pdo->prepare("SELECT * FROM items WHERE itemId = :id");
    $query->bindParam(':id', $id, PDO::PARAM_INT);
    $query->execute();
    return $query->fetch();
}

function getProductImage(string|null $image) {
    if ($image === null) {
        return _ASSETS_IMG_PATH_.'Default-product.png';
    } else {
        return _PRODUCTS_IMG_PATH_.$image;
    }
}

function getProducts(PDO $pdo, int $limit = null) {
    $sql = 'SELECT * FROM items ORDER BY itemId DESC';

    if ($limit) {
        $sql .= ' LIMIT :limit';
    }

    $query = $pdo->prepare($sql);

    if ($limit) {
        $query->bindParam(':limit', $limit, PDO::PARAM_INT);
    }

    $query->execute();
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

function getProductsSorted(PDO $pdo, int $limit = null, string $category) {
    $sql = 'SELECT * FROM items WHERE itemCategoryCode = :categoryCode ORDER BY itemId DESC';

    if ($limit) {
        $sql .= ' LIMIT :limit';
    }

    $query = $pdo->prepare($sql);
    $query->bindParam(':categoryCode', $category, PDO::PARAM_STR);

    if ($limit) {
        $query->bindParam(':limit', $limit, PDO::PARAM_INT);
    }

    $query->execute();
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

function createProduct(PDO $pdo, string $code, string $label, string $description, int $qty, string $categoryCode, int $vatCode, string|null $mainPicture, string $batchPrice) {
    // création du produit
    $sql='INSERT INTO items 
    (itemCode, itemLabel, itemDescription, itemQty, itemCategoryCode, itemVatCode, itemMainPicture, itemBatchPrice) 
    VALUES
    (:code, :label, :description, :qty, :categoryCode, :vatCode, :mainPicture, :batchPrice);';

    $query = $pdo->prepare($sql);
    $query->bindValue(':code', $code, PDO::PARAM_STR);
    $query->bindValue(':label', $label, PDO::PARAM_STR);
    $query->bindValue(':description', $description, PDO::PARAM_STR);
    $query->bindValue(':qty', $qty, PDO::PARAM_INT);
    $query->bindValue(':categoryCode', $categoryCode, PDO::PARAM_STR);
    $query->bindValue(':vatCode', $vatCode, PDO::PARAM_INT);
    $query->bindValue(':mainPicture', $mainPicture, PDO::PARAM_STR);
    $query->bindValue(':batchPrice', $batchPrice, PDO::PARAM_STR);
    return $query->execute();
}

function updateProduct(PDO $pdo, int $id, string $code, string $label, string $description, int $qty, string $categoryCode, int $vatCode, string|null $mainPicture, string $batchPrice) {
    // Mise à jour du produit
    $sql='UPDATE items 
        SET itemCode=:code, itemLabel=:label, itemDescription=:description, itemQty=:qty, itemCategoryCode=:categoryCode, itemVatCode=:vatCode, itemMainPicture=:mainPicture, itemBatchPrice=:batchPrice 
        WHERE itemId=:id;';

        $query = $pdo->prepare($sql);
        $query->bindValue(':id', $id, PDO::PARAM_STR);
        $query->bindValue(':code', $code, PDO::PARAM_STR);
        $query->bindValue(':label', $label, PDO::PARAM_STR);
        $query->bindValue(':description', $description, PDO::PARAM_STR);
        $query->bindValue(':qty', $qty, PDO::PARAM_INT);
        $query->bindValue(':categoryCode', $categoryCode, PDO::PARAM_STR);
        $query->bindValue(':vatCode', $vatCode, PDO::PARAM_INT);
        $query->bindValue(':mainPicture', $mainPicture, PDO::PARAM_STR);
        $query->bindValue(':batchPrice', $batchPrice, PDO::PARAM_STR);
        return $query->execute();
}