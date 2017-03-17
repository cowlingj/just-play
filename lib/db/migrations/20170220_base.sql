CREATE TABLE user (
  id SERIAL PRIMARY KEY,
  name VARCHAR(50) NOT NULL UNIQUE,
  disabled_flag BOOLEAN NOT NULL DEFAULT FALSE,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NOT NULL
    DEFAULT CURRENT_TIMESTAMP
    ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE credentials (
  user_id BIGINT UNSIGNED NOT NULL,
  service VARCHAR(50) NOT NULL UNIQUE,
  service_id VARCHAR(200) NOT NULL DEFAULT FALSE,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NOT NULL
    DEFAULT CURRENT_TIMESTAMP
    ON UPDATE CURRENT_TIMESTAMP,

  PRIMARY KEY (user_id, service),
  CONSTRAINT user_credentials_fk_con
    FOREIGN KEY user_credentials_fk(user_id)
    REFERENCES  user(id)
) ENGINE=InnoDB;

CREATE TABLE sport (
  id SERIAL PRIMARY KEY,
  name VARCHAR(40) NOT NULL UNIQUE,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NOT NULL
    DEFAULT CURRENT_TIMESTAMP
    ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE location (
  id SERIAL PRIMARY KEY,
  name VARCHAR(255) NOT NULL UNIQUE,
  latitude DECIMAL NOT NULL,
  longitude DECIMAL NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NOT NULL
    DEFAULT CURRENT_TIMESTAMP
    ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE broadcast (
  id SERIAL PRIMARY KEY,
  broadcaster BIGINT UNSIGNED NOT NULL,
  reciever BIGINT UNSIGNED NOT NULL,
  location BIGINT UNSIGNED NOT NULL,
  sport BIGINT UNSIGNED NOT NULL,
  disabled_flag BOOLEAN NOT NULL DEFAULT FALSE,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NOT NULL
    DEFAULT CURRENT_TIMESTAMP
    ON UPDATE CURRENT_TIMESTAMP,

  CONSTRAINT broadcaster_broadcast_fk_con
    FOREIGN KEY broadcaster_broadcast_fk(broadcaster)
    REFERENCES  user(id),

  CONSTRAINT reciever_broadcast_fk_con
    FOREIGN KEY reciever_broadcast_fk(reciever)
    REFERENCES  user(id),

  CONSTRAINT location_broadcast_fk_con
    FOREIGN KEY location_broadcast_fk(location)
    REFERENCES  location(id),

  CONSTRAINT sport_broadcast_fk_con
    FOREIGN KEY sport_broadcast_fk(sport)
    REFERENCES  sport(id)
) ENGINE=InnoDB;


--Clarification:
--Broadcaster turns into player1
--Receiver turns into player2
CREATE TABLE game (
  id SERIAL PRIMARY KEY,
  player1 BIGINT UNSIGNED NOT NULL,
  player2 BIGINT UNSIGNED NOT NULL,
  sport BIGINT UNSIGNED NOT NULL,
  location BIGINT UNSIGNED NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NOT NULL
    DEFAULT CURRENT_TIMESTAMP
    ON UPDATE CURRENT_TIMESTAMP,

  CONSTRAINT sport_match_fk_con
    FOREIGN KEY sport_match_fk(sport)
    REFERENCES  sport(id),

  CONSTRAINT location_match_fk_con
    FOREIGN KEY location_match_fk(location)
    REFERENCES  location(id),
  --The 2 players of a game
  CONSTRAINT player1_game_fk_con
    FOREIGN KEY player1_game_fk(player1)
    REFERENCES  user(id),

  CONSTRAINT player2_game_fk_con
    FOREIGN KEY player2_game_fk(player2)
    REFERENCES  user(id)
) ENGINE=InnoDB;

CREATE TABLE gamebuffer (
  game_id SERIAL PRIMARY KEY,
  player1_elo BIGINT UNSIGNED NOT NULL,             --Player1 elo at the start of this game
  player2_elo BIGINT UNSIGNED NOT NULL,             --Player2 elo at the start of this game
  --If feedback is null the playedr hasn't given feedback
  player1_feedback ENUM('WIN', 'LOSE', 'DRAW'),     --Feedback of player 1 given after game is played
  player2_feedback ENUM('WIN', 'LOSE', 'DRAW'),     --Feedback of player 2 given after game is played

  CONSTRAINT gameid_gamebuffer_fk_con
    FOREIGN KEY gameid_gamebuffer_fk(game_id)
    REFERENCES  game(id)
) ENGINE=InnoDB;

