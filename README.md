# Description:
This test task was done to demonstrate a typical Laravel web application.
## Requirements
- PHP 7.4
- Laravel 8
- MySQL 5.7
# Task:
Generate a standings where teams are divided into 2 divisions A and B, with 8 teams in each division.

**Seasonal Games:** 

In each division, teams play each with two seasonal matches, one at home and one away. The team that scores more goals per match will be the winner of the match. There must be one winner in each game. 

After all the games in the season, the top 4 teams from each division (with the most points) advance to the playoffs.

**Playoff games:** 

The schedule of playoff games is held according to the "tree" principle: the best team plays against the weakest, where the winner goes further, and the loser drops out of further participation. The team that scores more goals in a match will be the winner of the match. There must be one winner in each game. 

As a result, the team that wins all playoff games wins.

## Details:
- So that you do not have to enter all the results manually, implement a data generator, for example, by clicking on 
  the buttons, fill in the results for division A, B, and then for the playoff table
- UI on Laravel Blade
- The results should be saved to the database (mysql / postgresql)

# Deploy information
1. Clone the project from Git repository `git clone `
2. Rename root file `.env.example` to `.env`
3. Add to `.env` file information about DataBase connection
4. Run `composer install`
5. Upload test data to DB from root file `dump.sql`
   **OR run** migration `php artisan migrate --seed` with Seeder
6. Run `npm install` and then `npm run prod`
7. 

# Usage
Come to main page. 

Click on button SimulateSeasonGames and then on button SimulatePlayoffGames.

