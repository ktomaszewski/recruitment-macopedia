<?php

declare(strict_types=1);

namespace Application\Migration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20210903123000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Adds tables for products and categories';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(/** @lang MySQL */ <<< SQL
            CREATE TABLE Products (
                id VARCHAR(128) NOT NULL,
                name VARCHAR(255) NOT NULL,
                CONSTRAINT PK_Products_id PRIMARY KEY (id),
                INDEX IX_Products_name (name)
            );
        SQL);

        $this->addSql(/** @lang MySQL */ <<< SQL
            CREATE TABLE Categories (
                id BINARY(16) NOT NULL,
                name VARCHAR(255) NOT NULL,
                CONSTRAINT PK_Categories_id PRIMARY KEY (id),
                INDEX IX_Categories_name (name)
            );
        SQL);

        $this->addSql(/** @lang MySQL */ <<< SQL
            CREATE TABLE Products_Categories (
                product_id VARCHAR(128) NOT NULL,
                category_id BINARY(16) NOT NULL,
                CONSTRAINT PK_Products_Categories_product_id_category_id PRIMARY KEY (product_id, category_id),
                INDEX IX_Products_Categories_category_id (category_id)
            );
        SQL);
    }

    public function down(Schema $schema): void
    {
        $this->addSql(/** @lang MySQL */ <<< SQL
            DROP TABLE Products_Categories;
        SQL);

        $this->addSql(/** @lang MySQL */ <<< SQL
            DROP TABLE Categories;
        SQL);

        $this->addSql(/** @lang MySQL */ <<< SQL
            DROP TABLE Products;
        SQL);
    }
}
