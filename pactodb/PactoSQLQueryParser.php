<?php
/**
 * Created by PhpStorm.
 * User: felipe
 * Date: 12/12/2014
 * Time: 18:38
 */

class PactoSQLQueryParser {
    static public function SelectUserByName($playerName) {
        $strQuery = 'select *
                      from players
                      where players.playername = \''.$playerName.'\';';

        return $strQuery;
    }

    static public function SelectLevelById($levelId) {
        $strQuery = 'select *
                      from levels
                      where levels.levelid = '.$levelId.';';
        return $strQuery;
    }

    static public function SelectPlayerProgress($playerId) {
        $strQuery = 'select player_progress.levelid
                      from players, player_progress
                      where players.playerid = player_progress.playerid
                        and players.playername = \''.$playerId.'\';';
        return $strQuery;
    }

    static public function InsertPlayer($playerName,$playerPassword) {
        $strQuery = 'insert into players (playername, playerpassword)
                      values (\''.$playerName.'\', \''.$playerPassword.'\')';
        return $strQuery;
    }

    static public function SavePlayerScore($playerId, $levelId, $score, $scoreTimeStamp) {
        $strQuery = 'INSERT INTO scores (userid, levelid, score, scoreTimeStamp)
                    VALUES ('.$playerId.', '.$levelId.', '.$score.', \''.$scoreTimeStamp.'\');';
        return $strQuery;
    }

    static public function InsertPlayerProgress($playerId, $levelId) {
        $strQuery = 'INSERT INTO player_progress
                      VALUES ('.$playerId.', '.$levelId.');';
        return $strQuery;
    }

    static public function UpdatePlayerProgress($playerId, $levelId) {
        $strQuery = 'UPDATE player_progress
                      SET player_progress.levelid = '.$levelId.'
                      WHERE player_progress.playerid = '.$playerId.';';
        return $strQuery;
    }

    static public function SelectScoresByLevel($levelId) {
        $strQuery = 'SELECT players.playername, scores.score
                      FROM players, scores
                      WHERE players.playerid = scores.userid
	                    AND scores.levelid = '.$levelId.'
                      ORDER BY score DESC';
        return $strQuery;
    }

    static public function SelectScoresByLevelBetweenDates($levelId, $startDate, $endDate) {
        $strQuery = 'SELECT FROM players, scores
                      WHERE players.playerid = scores.userid
                        AND scores.levelid = '.$levelId.'
                        AND (scores.scoretimestamp BETWEEN \''.$startDate.'\' AND \''.$endDate.'\')
                      ORDER BY scores.score DESC;';
        return $strQuery;
    }

    static public function SelectTopScoresFromEachLevel() {
        $strQuery = 'SELECT levels.levelid, levels.levelname, players.playername, score
                      FROM scores, levels, players
                      WHERE levels.levelid = scores.levelid
                        AND players.playerid = scores.userid
                        AND score = (SELECT MAX(score)
                                      FROM scores
                                      WHERE levels.levelid = scores.levelid)
                      ORDER BY levels.levelid;';
        return $strQuery;
    }

    static public function SelectTopScoresFromEachLevelBetweenDates($startDate, $endDate) {
        $strQuery = 'SELECT levels.levelid, levels.levelname, players.playername, score
                      FROM scores, levels, players
                      WHERE levels.levelid = scores.levelid
                        AND players.playerid = scores.userid
                        AND score = (SELECT MAX(score)
                                      FROM scores
                                      WHERE levels.levelid = scores.levelid)
                        AND (scoreTimeStamp BETWEEN \''.$startDate.'\' AND \''.$endDate.'\')
                      ORDER BY levels.levelid;';
        return $strQuery;
    }

    static public function SelectLevelTopScores($levelId) {
        $strQuery = 'SELECT levels.levelid, levels.levelname, players.playername, score
                      FROM scores, levels, players
                      WHERE levels.levelid = '.$levelId.'
	                    AND players.playerid = scores.userid
                        AND score = (SELECT MAX(score)
                                      FROM scores
                                      WHERE scores.levelid = '.$levelId.')
	                  ORDER BY levels.levelid;';
        return $strQuery;
    }

    static public function SelectLevelTopScoresBetweenDates($levelId, $startDate, $endDate) {
        $strQuery = 'SELECT levels.levelid, levels.levelname, players.playername, score
                      FROM scores, levels, players
                      WHERE levels.levelid = '.$levelId.'
	                    AND players.playerid = scores.userid
                        AND score = (SELECT MAX(score)
                                      FROM scores
                                      WHERE scores.levelid = '.$levelId.')
                        AND (scoreTimeStamp between \''.$startDate.'\' and \''.$endDate.'\')
	                  ORDER BY levels.levelid;';
        return $strQuery;
    }
}