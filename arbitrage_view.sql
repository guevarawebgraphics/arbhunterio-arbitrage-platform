CREATE VIEW arbitrage AS
SELECT 
  sub.*,
  CASE
    WHEN (sub.best_over_odds IS NOT NULL) OR (sub.best_under_odds IS NOT NULL )
      THEN ROUND(ABS(100 * (1 - (1 / sub.best_over_odds + 1 / sub.best_under_odds))), 2)
    WHEN (sub.best_home_odds IS NOT NULL) OR (sub.best_away_odds IS NOT NULL ) 
      THEN ROUND(ABS(100 * (1 - (1 / sub.best_home_odds + 1 / sub.best_away_odds))), 2)
    WHEN sub.draw_count > 0 
      THEN ROUND(ABS(100 * (1 - (1 / sub.best_home_odds + 1 / sub.best_home_odds))), 2)
    WHEN (sub.best_yes_odds IS NOT NULL) OR (sub.best_no_odds IS NOT NULL ) 
      THEN ROUND(ABS(100 * (1 - (1 / sub.best_yes_odds + 1 / sub.best_no_odds))), 2)
    WHEN (sub.best_odd_odds IS NOT NULL) OR (sub.best_even_odds IS NOT NULL ) 
      THEN ROUND(ABS(100 * (1 - (1 / sub.best_odd_odds + 1 / sub.best_even_odds))), 2)
    ELSE 0
  END AS profit_percentage
FROM (
    SELECT g.uid, g.start_date, g.home_team, g.away_team, go.bet_type, g.sport, g.league,
    -- Over and Under
    ( SELECT max(x.bet_price)  FROM gameodds AS x WHERE x.game_id = go.game_id AND x.bet_type = go.bet_type AND x.selection_line = 'over' ) AS max_over_bet_price, 
    ( SELECT max(x.bet_price)  FROM gameodds AS x WHERE x.game_id = go.game_id AND x.bet_type = go.bet_type AND x.selection_line = 'under' ) AS max_under_bet_price,


    ( SELECT CASE 
            WHEN MAX(bet_price) > 0 THEN (MAX(bet_price) / 100) + 1
            ELSE (100 / ABS(MAX(bet_price))) + 1
        END  FROM gameodds AS x WHERE x.game_id = go.game_id AND x.bet_type = go.bet_type AND x.selection_line = 'over' ) AS best_over_odds,
    ( SELECT CASE 
            WHEN MAX(bet_price) > 0 THEN (MAX(bet_price) / 100) + 1
            ELSE (100 / ABS(MAX(bet_price))) + 1
        END  FROM gameodds AS x WHERE x.game_id = go.game_id AND x.bet_type = go.bet_type AND x.selection_line = 'under' ) AS best_under_odds,
        
    -- Draw
    ( SELECT COUNT(selection)  FROM gameodds AS x WHERE x.game_id = go.game_id AND x.bet_type = go.bet_type AND x.selection = 'Draw' ) AS draw_count,
    -- Home and Away
    ( SELECT max(x.bet_price)  FROM gameodds AS x WHERE x.game_id = go.game_id AND x.bet_type = go.bet_type AND x.selection = g.home_team ) AS max_home_bet_price, 
    ( SELECT max(x.bet_price)  FROM gameodds AS x WHERE x.game_id = go.game_id AND x.bet_type = go.bet_type AND x.selection = g.away_team ) AS max_away_bet_price,

    ( SELECT CASE 
            WHEN MAX(bet_price) > 0 THEN (MAX(bet_price) / 100) + 1
            ELSE (100 / ABS(MAX(bet_price))) + 1
        END  FROM gameodds AS x WHERE x.game_id = go.game_id AND x.bet_type = go.bet_type AND x.selection_line = g.home_team ) AS best_home_odds,
    ( SELECT CASE 
            WHEN MAX(bet_price) > 0 THEN (MAX(bet_price) / 100) + 1
            ELSE (100 / ABS(MAX(bet_price))) + 1
        END  FROM gameodds AS x WHERE x.game_id = go.game_id AND x.bet_type = go.bet_type AND x.selection_line = g.away_team ) AS best_away_odds,
    -- Yes and No
    ( SELECT max(x.bet_price)  FROM gameodds AS x WHERE x.game_id = go.game_id AND x.bet_type = go.bet_type AND x.selection_line = 'yes' ) AS max_yes_bet_price, 
    ( SELECT max(x.bet_price)  FROM gameodds AS x WHERE x.game_id = go.game_id AND x.bet_type = go.bet_type AND x.selection_line = 'no' ) AS max_no_bet_price,

    ( SELECT CASE 
                            WHEN MAX(bet_price) > 0 THEN (MAX(bet_price) / 100) + 1
                            ELSE (100 / ABS(MAX(bet_price))) + 1
                        END  FROM gameodds AS x WHERE x.game_id = go.game_id AND x.bet_type = go.bet_type AND x.selection_line = 'yes' ) AS best_yes_odds,
    ( SELECT CASE 
                            WHEN MAX(bet_price) > 0 THEN (MAX(bet_price) / 100) + 1
                            ELSE (100 / ABS(MAX(bet_price))) + 1
                        END  FROM gameodds AS x WHERE x.game_id = go.game_id AND x.bet_type = go.bet_type AND x.selection_line = 'no' ) AS best_no_odds,     
    -- Odd and Even
    ( SELECT max(x.bet_price)  FROM gameodds AS x WHERE x.game_id = go.game_id AND x.bet_type = go.bet_type AND x.selection_line = 'odd' ) AS max_odd_bet_price, 
    ( SELECT max(x.bet_price)  FROM gameodds AS x WHERE x.game_id = go.game_id AND x.bet_type = go.bet_type AND x.selection_line = 'even' ) AS max_even_bet_price,

    ( SELECT CASE 
                            WHEN MAX(bet_price) > 0 THEN (MAX(bet_price) / 100) + 1
                            ELSE (100 / ABS(MAX(bet_price))) + 1
                        END  FROM gameodds AS x WHERE x.game_id = go.game_id AND x.bet_type = go.bet_type AND x.selection_line = 'odd' ) AS best_odd_odds,
    ( SELECT CASE 
                            WHEN MAX(bet_price) > 0 THEN (MAX(bet_price) / 100) + 1
                            ELSE (100 / ABS(MAX(bet_price))) + 1
                        END  FROM gameodds AS x WHERE x.game_id = go.game_id AND x.bet_type = go.bet_type AND x.selection_line = 'even' ) AS best_even_odds
    FROM gameodds AS go
    LEFT JOIN games AS g ON g.uid = go.game_id
    GROUP BY g.uid, go.bet_type, g.start_date 
) AS sub;