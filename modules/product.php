<?php
function getProductById(PDO $pdo, int $id) {
    $query = $pdo->prepare("SELECT * FROM items WHERE itemId = :id");
    $query->bindParam(':id', $id, PDO::PARAM_INT);
    $query->execute();
    return $query->fetch();
}

function getProductImage(string|null $image) {
    if ($image === null) {
        return _ASSETS_IMG_PATH_.'default-product.jpg';
    } else {
        return _PRODUCT_IMG_PATH_.$image;
    }
}

function getProduct(PDO $pdo, int $limit = null) {
    $sql = 'SELECT * FROM items ORDER BY itemId DESC';

    if ($limit) {
        $sql .= ' LIMIT :limit';
    }

    $query = $pdo->prepare($sql);

    if ($limit) {
        $query->bindParam(':limit', $limit, PDO::PARAM_INT);
    }

    $query->execute();
    return $query->fetchAll();
}