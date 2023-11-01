WITH OverUnder AS (
    SELECT game_id, bet_type,
        MAX(CASE WHEN selection_line = 'over' THEN bet_price ELSE NULL END) AS max_over_bet_price,
        MAX(CASE WHEN selection_line = 'under' THEN bet_price ELSE NULL END) AS max_under_bet_price,
        MAX(CASE WHEN selection_line = 'over' THEN 
            CASE WHEN bet_price > 0 THEN (bet_price / 100) + 1 ELSE (100 / ABS(bet_price)) + 1 END 
        ELSE NULL END) AS best_over_odds,
        MAX(CASE WHEN selection_line = 'under' THEN 
            CASE WHEN bet_price > 0 THEN (bet_price / 100) + 1 ELSE (100 / ABS(bet_price)) + 1 END 
        ELSE NULL END) AS best_under_odds
    FROM gameodds
    GROUP BY game_id, bet_type
),

Draw AS (
    SELECT game_id, bet_type,
        COUNT(CASE WHEN selection = 'Draw' THEN 1 ELSE NULL END) AS draw_count
    FROM gameodds
    GROUP BY game_id, bet_type
),

HomeAway AS (
    SELECT go.game_id, go.bet_type, g.home_team, g.away_team,
        MAX(CASE WHEN selection = g.home_team THEN bet_price ELSE NULL END) AS max_home_bet_price,
        MAX(CASE WHEN selection = g.away_team THEN bet_price ELSE NULL END) AS max_away_bet_price,
        MAX(CASE WHEN selection_line = g.home_team THEN 
            CASE WHEN bet_price > 0 THEN (bet_price / 100) + 1 ELSE (100 / ABS(bet_price)) + 1 END 
        ELSE NULL END) AS best_home_odds,
        MAX(CASE WHEN selection_line = g.away_team THEN 
            CASE WHEN bet_price > 0 THEN (bet_price / 100) + 1 ELSE (100 / ABS(bet_price)) + 1 END 
        ELSE NULL END) AS best_away_odds
    FROM gameodds AS go
    JOIN games AS g ON go.game_id = g.uid
    GROUP BY go.game_id, go.bet_type, g.home_team, g.away_team
),

YesNo AS (
    SELECT game_id, bet_type,
        MAX(CASE WHEN selection_line = 'yes' THEN bet_price ELSE NULL END) AS max_yes_bet_price,
        MAX(CASE WHEN selection_line = 'no' THEN bet_price ELSE NULL END) AS max_no_bet_price,
        MAX(CASE WHEN selection_line = 'yes' THEN 
            CASE WHEN bet_price > 0 THEN (bet_price / 100) + 1 ELSE (100 / ABS(bet_price)) + 1 END 
        ELSE NULL END) AS best_yes_odds,
        MAX(CASE WHEN selection_line = 'no' THEN 
            CASE WHEN bet_price > 0 THEN (bet_price / 100) + 1 ELSE (100 / ABS(bet_price)) + 1 END 
        ELSE NULL END) AS best_no_odds
    FROM gameodds
    GROUP BY game_id, bet_type
),

OddEven AS (
    SELECT game_id, bet_type,
        MAX(CASE WHEN selection_line = 'odd' THEN bet_price ELSE NULL END) AS max_odd_bet_price,
        MAX(CASE WHEN selection_line = 'even' THEN bet_price ELSE NULL END) AS max_even_bet_price,
        MAX(CASE WHEN selection_line = 'odd' THEN 
            CASE WHEN bet_price > 0 THEN (bet_price / 100) + 1 ELSE (100 / ABS(bet_price)) + 1 END 
        ELSE NULL END) AS best_odd_odds,
        MAX(CASE WHEN selection_line = 'even' THEN 
            CASE WHEN bet_price > 0 THEN (bet_price / 100) + 1 ELSE (100 / ABS(bet_price)) + 1 END 
        ELSE NULL END) AS best_even_odds
    FROM gameodds
    GROUP BY game_id, bet_type
),

ProfitPercentage AS (
    SELECT go.game_id, go.bet_type,
        CASE
            WHEN (OverUnder.best_over_odds IS NOT NULL) OR (OverUnder.best_under_odds IS NOT NULL)
            THEN ROUND(ABS(100 * (1 - (1 / OverUnder.best_over_odds + 1 / OverUnder.best_under_odds))), 2)

            WHEN Draw.draw_count > 0 
            THEN ROUND(ABS(100 * (1 - (1 / HomeAway.best_home_odds + 1 / HomeAway.best_home_odds))), 2)

            WHEN (HomeAway.best_home_odds IS NOT NULL) OR (HomeAway.best_away_odds IS NOT NULL) 
            THEN ROUND(ABS(100 * (1 - (1 / HomeAway.best_home_odds + 1 / HomeAway.best_away_odds))), 2)

            WHEN (YesNo.best_yes_odds IS NOT NULL) OR (YesNo.best_no_odds IS NOT NULL) 
            THEN ROUND(ABS(100 * (1 - (1 / YesNo.best_yes_odds + 1 / YesNo.best_no_odds))), 2)

            WHEN (OddEven.best_odd_odds IS NOT NULL) OR (OddEven.best_even_odds IS NOT NULL) 
            THEN ROUND(ABS(100 * (1 - (1 / OddEven.best_odd_odds + 1 / OddEven.best_even_odds))), 2)

            ELSE 0
        END AS profit_percentage
    FROM gameodds AS go
    LEFT JOIN OverUnder ON go.game_id = OverUnder.game_id AND go.bet_type = OverUnder.bet_type
    LEFT JOIN Draw ON go.game_id = Draw.game_id AND go.bet_type = Draw.bet_type
    LEFT JOIN HomeAway ON go.game_id = HomeAway.game_id AND go.bet_type = HomeAway.bet_type
    LEFT JOIN YesNo ON go.game_id = YesNo.game_id AND go.bet_type = YesNo.bet_type
    LEFT JOIN OddEven ON go.game_id = OddEven.game_id AND go.bet_type = OddEven.bet_type
)

SELECT g.uid, g.start_date, g.home_team, g.away_team, go.bet_type, g.sport, g.league,
    OverUnder.max_over_bet_price, OverUnder.max_under_bet_price, OverUnder.best_over_odds, OverUnder.best_under_odds,
    Draw.draw_count,
    HomeAway.max_home_bet_price, HomeAway.max_away_bet_price, HomeAway.best_home_odds, HomeAway.best_away_odds,
    YesNo.max_yes_bet_price, YesNo.max_no_bet_price, YesNo.best_yes_odds, YesNo.best_no_odds,
    OddEven.max_odd_bet_price, OddEven.max_even_bet_price, OddEven.best_odd_odds, OddEven.best_even_odds,
    pp.profit_percentage -- Selecting the profit_percentage from the ProfitPercentage CTE
FROM games AS g
LEFT JOIN gameodds AS go ON g.uid = go.game_id
LEFT JOIN OverUnder ON go.game_id = OverUnder.game_id AND go.bet_type = OverUnder.bet_type
LEFT JOIN Draw ON go.game_id = Draw.game_id AND go.bet_type = Draw.bet_type
LEFT JOIN HomeAway ON go.game_id = HomeAway.game_id AND go.bet_type = HomeAway.bet_type
LEFT JOIN YesNo ON go.game_id = YesNo.game_id AND go.bet_type = YesNo.bet_type
LEFT JOIN OddEven ON go.game_id = OddEven.game_id AND go.bet_type = OddEven.bet_type
LEFT JOIN ProfitPercentage pp ON go.game_id = pp.game_id AND go.bet_type = pp.bet_type -- Joining the ProfitPercentage CTE
GROUP BY g.uid, go.bet_type, g.start_date LIMIT 10;