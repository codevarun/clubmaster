<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20120306123625 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is autogenerated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql");

        $this->addSql("ALTER TABLE club_ranking_match_team DROP FOREIGN KEY FK_6349B8062ABEACD6");
        $this->addSql("ALTER TABLE club_ranking_match_team ADD CONSTRAINT FK_6349B8062ABEACD6 FOREIGN KEY (match_id) REFERENCES club_ranking_match(id) ON DELETE CASCADE");
        $this->addSql("ALTER TABLE club_ranking_match_set DROP FOREIGN KEY FK_282C5D382ABEACD6");
        $this->addSql("ALTER TABLE club_ranking_match_set ADD CONSTRAINT FK_282C5D382ABEACD6 FOREIGN KEY (match_id) REFERENCES club_ranking_match(id) ON DELETE CASCADE");
        $this->addSql("ALTER TABLE club_ranking_match_team_user DROP FOREIGN KEY FK_B6ABBBAC5ECA87C1");
        $this->addSql("ALTER TABLE club_ranking_match_team_user ADD CONSTRAINT FK_B6ABBBAC5ECA87C1 FOREIGN KEY (match_team_id) REFERENCES club_ranking_match_team(id) ON DELETE CASCADE");
    }

    public function down(Schema $schema)
    {
        // this down() migration is autogenerated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql");

        $this->addSql("ALTER TABLE club_ranking_match_set DROP FOREIGN KEY FK_282C5D382ABEACD6");
        $this->addSql("ALTER TABLE club_ranking_match_set ADD CONSTRAINT FK_282C5D382ABEACD6 FOREIGN KEY (match_id) REFERENCES club_ranking_match(id)");
        $this->addSql("ALTER TABLE club_ranking_match_team DROP FOREIGN KEY FK_6349B8062ABEACD6");
        $this->addSql("ALTER TABLE club_ranking_match_team ADD CONSTRAINT FK_6349B8062ABEACD6 FOREIGN KEY (match_id) REFERENCES club_ranking_match(id)");
        $this->addSql("ALTER TABLE club_ranking_match_team_user DROP FOREIGN KEY FK_B6ABBBAC5ECA87C1");
        $this->addSql("ALTER TABLE club_ranking_match_team_user ADD CONSTRAINT FK_B6ABBBAC5ECA87C1 FOREIGN KEY (match_team_id) REFERENCES club_ranking_match_team(id)");
    }
}
