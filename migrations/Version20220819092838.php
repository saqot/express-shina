<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220819092838 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE brand (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(150) NOT NULL, UNIQUE INDEX UNIQ_1C52F9585E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'Производители\' ');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, model_id INT NOT NULL, name VARCHAR(150) NOT NULL, INDEX IDX_D34A04AD7975B7E7 (model_id), UNIQUE INDEX UNIQ_NAME_PRODUCT_MODEL (name, model_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'Товар\' ');
        $this->addSql('CREATE TABLE product_model (id INT AUTO_INCREMENT NOT NULL, type_id INT NOT NULL, brand_id INT NOT NULL, name VARCHAR(150) NOT NULL, INDEX IDX_76C90985C54C8C93 (type_id), INDEX IDX_76C9098544F5D008 (brand_id), UNIQUE INDEX UNIQ_NAME_MODEL_TYPE_BRAND2 (name, type_id, brand_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'Модель товара\' ');
        $this->addSql('CREATE TABLE product_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(150) NOT NULL, UNIQUE INDEX UNIQ_13675885E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'Тип товара\' ');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD7975B7E7 FOREIGN KEY (model_id) REFERENCES product_model (id)');
        $this->addSql('ALTER TABLE product_model ADD CONSTRAINT FK_76C90985C54C8C93 FOREIGN KEY (type_id) REFERENCES product_type (id)');
        $this->addSql('ALTER TABLE product_model ADD CONSTRAINT FK_76C9098544F5D008 FOREIGN KEY (brand_id) REFERENCES brand (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD7975B7E7');
        $this->addSql('ALTER TABLE product_model DROP FOREIGN KEY FK_76C90985C54C8C93');
        $this->addSql('ALTER TABLE product_model DROP FOREIGN KEY FK_76C9098544F5D008');
        $this->addSql('DROP TABLE brand');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE product_model');
        $this->addSql('DROP TABLE product_type');
    }
}
