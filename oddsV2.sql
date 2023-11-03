WITH PriceOddsCalc AS (
    SELECT go.game_id, go.bet_type, go.selection, go.selection_line, go.bet_price,
           CASE
               WHEN go.bet_price > 0 THEN (go.bet_price / 100) + 1
               ELSE (100 / ABS(go.bet_price)) + 1
           END AS calculated_odds
    FROM gameodds AS go
),

AggregatedData AS (
    SELECT go.game_id, go.bet_type,
        MAX(CASE WHEN go.selection_line = 'over' THEN go.bet_price ELSE NULL END) AS max_over_bet_price,
        MAX(CASE WHEN go.selection_line = 'under' THEN go.bet_price ELSE NULL END) AS max_under_bet_price,
        MAX(CASE WHEN go.selection_line = 'over' THEN poc.calculated_odds ELSE NULL END) AS best_over_odds,
        MAX(CASE WHEN go.selection_line = 'under' THEN poc.calculated_odds ELSE NULL END) AS best_under_odds,
        COUNT(CASE WHEN go.selection = 'Draw' THEN 1 ELSE NULL END) AS draw_count,
        MAX(CASE WHEN go.selection = g.home_team THEN  go.bet_price ELSE NULL END) AS max_home_bet_price,
        MAX(CASE WHEN go.selection = g.away_team THEN  go.bet_price ELSE NULL END) AS max_away_bet_price,
        MAX(CASE WHEN go.selection = g.home_team THEN poc.calculated_odds ELSE NULL END) AS best_home_odds,
        MAX(CASE WHEN go.selection = g.away_team THEN poc.calculated_odds ELSE NULL END) AS best_away_odds,
        MAX(CASE WHEN go.selection_line = 'yes' THEN  go.bet_price ELSE NULL END) AS max_yes_bet_price,
        MAX(CASE WHEN go.selection_line = 'no' THEN  go.bet_price ELSE NULL END) AS max_no_bet_price,
        MAX(CASE WHEN go.selection_line = 'yes' THEN poc.calculated_odds ELSE NULL END) AS best_yes_odds,
        MAX(CASE WHEN go.selection_line = 'no' THEN poc.calculated_odds ELSE NULL END) AS best_no_odds,
        MAX(CASE WHEN go.selection_line = 'odd' THEN  go.bet_price ELSE NULL END) AS max_odd_bet_price,
        MAX(CASE WHEN go.selection_line = 'even' THEN  go.bet_price ELSE NULL END) AS max_even_bet_price,
        MAX(CASE WHEN go.selection_line = 'odd' THEN poc.calculated_odds ELSE NULL END) AS best_odd_odds,
        MAX(CASE WHEN go.selection_line = 'even' THEN poc.calculated_odds ELSE NULL END) AS best_even_odds
    FROM gameodds AS go
    JOIN games AS g ON go.game_id = g.uid
    JOIN PriceOddsCalc poc ON go.game_id = poc.game_id AND go.bet_type = poc.bet_type AND go.selection = poc.selection AND go.selection_line = poc.selection_line
    GROUP BY go.game_id, go.bet_type
)

SELECT 
    g.uid, g.start_date, g.home_team, g.away_team, go.bet_type, g.sport, g.league,
    ad.max_over_bet_price, ad.max_under_bet_price, ad.best_over_odds, ad.best_under_odds,
    ad.draw_count,
    ad.max_home_bet_price, ad.max_away_bet_price, ad.best_home_odds, ad.best_away_odds,
    ad.max_yes_bet_price, ad.max_no_bet_price, ad.best_yes_odds, ad.best_no_odds,
    ad.max_odd_bet_price, ad.max_even_bet_price, ad.best_odd_odds, ad.best_even_odds,
    CASE
        WHEN (ad.best_over_odds IS NOT NULL) OR (ad.best_under_odds IS NOT NULL)
        THEN ROUND(ABS(100 * (1 - (1 / ad.best_over_odds + 1 / ad.best_under_odds))), 2)

        WHEN ad.draw_count > 0 
        THEN ROUND(ABS(100 * (1 - (1 / ad.best_home_odds + 1 / ad.best_home_odds))), 2)

        WHEN (ad.best_home_odds IS NOT NULL) OR (ad.best_away_odds IS NOT NULL) 
        THEN ROUND(ABS(100 * (1 - (1 / ad.best_home_odds + 1 / ad.best_away_odds))), 2)

        WHEN (ad.best_yes_odds IS NOT NULL) OR (ad.best_no_odds IS NOT NULL) 
        THEN ROUND(ABS(100 * (1 - (1 / ad.best_yes_odds + 1 / ad.best_no_odds))), 2)

        WHEN (ad.best_odd_odds IS NOT NULL) OR (ad.best_even_odds IS NOT NULL) 
        THEN ROUND(ABS(100 * (1 - (1 / ad.best_odd_odds + 1 / ad.best_even_odds))), 2)

        ELSE 0
    END AS profit_percentage
FROM games AS g
LEFT JOIN gameodds AS go ON g.uid = go.game_id
LEFT JOIN AggregatedData ad ON go.game_id = ad.game_id AND go.bet_type = ad.bet_type
GROUP BY g.uid, go.bet_type, g.start_date LIMIT 10;
