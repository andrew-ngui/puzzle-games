# Puzzle Games
PHP based website hosting simple puzzles and user login + score tracking. Uses postgreSQL database for user data storage.

# Format
Architected using Model View Controller format and a finite machine for frontend view. All requests go through index.php. Allows for front-end/back-end isolation and modular code.

# Games
- Guess Game: determine the hidden number in the least number of guesses.
- Fifteen Puzzle: rearrange the 4x4 grid to get all numbers in sequential order in the least amount of possible moves.
- Peg Solitaire: move a peg over another to eliminate it. Try to minimze number of pegs leftover.
- Mastermind: determine the hidden sequence of colors in the least number of guesses.

# Features
- Validation on front-end on back-end for user registration
- Prepared queries for the database to avoid sql injection
- Profile page to display all game scores and user information


CSC309 Web Programming at University of Toronto Mississauga 2020
