<?php
/**
 * Created by PhpStorm.
 * User: felipe
 * Date: 12/12/2014
 * Time: 18:38
 */

class PactoSQLQueryParser {
    static public function selectPlayerByName($playerName) {
        $strQuery = 'SELECT *
                      FROM players
                      WHERE players.playername = \''.$playerName.'\';';

        return $strQuery;
    }

    static public function getPlayerId($playerName) {
        $strQuery = 'SELECT players.playerid
                      FROM players
                      WHERE players.playername = \''.$playerName.'\';';
        return $strQuery;
    }

    static public function selectPlayers() {
        $strQuery = 'SELECT *
                      FROM players;';

        return $strQuery;
    }

    static public function insertPlayer($playerName,$playerPassword) {
        $strQuery = 'insert into players (playername, playerpassword)
                      values (\''.$playerName.'\', \''.$playerPassword.'\');';
        return $strQuery;
    }

    static public function updatePlayer($playerName, $newPlayerName, $newPlayerPassword) {
        $strQuery = 'UPDATE players
                      SET players.playername = \''.$newPlayerName.'\',
                         players.playerpassword = \''.$newPlayerPassword.'\'
                      WHERE players.playername = \''.$playerName.'\';';
        return $strQuery;
    }

    static public function deletePlayer($playerName) {
        $strQuery = 'DELETE FROM players
                      WHERE players.playername = \''.$playerName.'\';';
        return $strQuery;
    }

    static public function insertPlayerScore($playerId, $levelId, $score, $scoreTimeStamp) {
        $strQuery = 'INSERT INTO scores (userid, levelid, score, scoreTimeStamp)
                      VALUES ('.$playerId.', '.$levelId.', '.$score.', \''.$scoreTimeStamp.'\');';
        return $strQuery;
    }

    static public function updatePlayerScore($playerId, $levelId, $score, $scoreTimeStamp) {
        $strQuery = 'UPDATE scores
                      SET scores.score = '.$score.',
                          scores.scoreTimeStamp = \''.$scoreTimeStamp.'\'
                      WHERE scores.userid = '.$playerId.'
                        AND scores.levelid = '.$levelId.'
                        AND scores.score < '.$score.';';
        return $strQuery;
    }

    static public function selectPlayerScore($playerId, $levelId){
        $strQuery = 'SELECT scores.score
                      FROM scores
                      WHERE scores.userid = '.$playerId.'
                        AND scores.levelid = '.$levelId.';';
        return $strQuery;
    }

    static public function selectPLayerScores($playerId) {
        $strQuery = 'SELECT scores.userid, levels.levelname, scores.score
                      FROM scores, levels
                      WHERE scores.userid = '.$playerId.'
                        AND scores.levelid = levels.levelid
                      ORDER BY levels.levelname;';
        return $strQuery;
    }

    static public function deletePlayerScore($playerId) {
        $strQuery = 'DELETE scores
                      FROM scores
                      WHERE scores.userid = '.$playerId.';';
        return $strQuery;
    }

    static public function selectLevelById($levelId) {
        $strQuery = 'SELECT *
                      FROM levels
                      WHERE levels.levelid = '.$levelId.';';
        return $strQuery;
    }

    static public function selectLevelByName($levelName) {
        $strQuery = 'select *
                      from levels
                      where levels.levelname = \''.$levelName.'\';';
        return $strQuery;
    }

    static public function selectPlayerProgress($playerId) {
        $strQuery = 'SELECT levels.levelname
                      FROM players, player_progress, levels
                      WHERE players.playerid = player_progress.playerid
                        AND levels.levelid = player_progress.levelid
                        AND players.playerid = \''.$playerId.'\';';
        return $strQuery;
    }

    static public function selectPlayerProgressByName($playerName) {
        $strQuery = 'SELECT levels.levelname
                      FROM players, player_progress, levels
                      WHERE players.playerid = player_progress.playerid
                        AND levels.levelid = player_progress.levelid
                        AND players.playername = \''.$playerName.'\';';
        return $strQuery;
    }

    static public function insertPlayerProgress($playerId, $levelId) {
        $strQuery = 'INSERT INTO player_progress
                      VALUES ('.$playerId.', '.$levelId.');';
        return $strQuery;
    }

    static public function updatePlayerProgress($playerId, $levelId) {
        $strQuery = 'UPDATE player_progress
                      SET player_progress.levelid = '.$levelId.'
                      WHERE player_progress.playerid = '.$playerId.';';
        return $strQuery;
    }

    static public function deletePlayerProgress($playerName) {
        $strQuery = 'DELETE player_progress
                      FROM player_progress, players
                      WHERE players.playername = \''.$playerName.'\'
                      AND player_progress.playerId = players.playerId';
        return $strQuery;
    }

    static public function selectScoresByLevel($levelId) {
        $strQuery = 'SELECT players.playername, scores.score
                      FROM players, scores
                      WHERE players.playerid = scores.userid
	                    AND scores.levelid = '.$levelId.'
                      ORDER BY score DESC';
        return $strQuery;
    }

    static public function selectScoresByLevelBetweenDates($levelId, $startDate, $endDate) {
        $strQuery = 'SELECT *
                      FROM players, scores
                      WHERE players.playerid = scores.userid
                        AND scores.levelid = '.$levelId.'
                        AND (scores.scoretimestamp BETWEEN \''.$startDate.'\' AND \''.$endDate.'\')
                      ORDER BY scores.score DESC;';
        return $strQuery;
    }

    static public function selectTopScoresFromEachLevel() {
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

    static public function selectTopScoresFromEachLevelBetweenDates($startDate, $endDate) {
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

    static public function selectLevelTopScores($levelId) {
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

    static public function selectLevelTopScoresBetweenDates($levelId, $startDate, $endDate) {
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