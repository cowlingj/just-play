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


CREATE TABLE game (
  id SERIAL PRIMARY KEY,
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
    REFERENCES  location(id)
) ENGINE=InnoDB;

CREATE TABLE player (
  game_id BIGINT UNSIGNED NOT NULL,
  player_id BIGINT UNSIGNED NOT NULL,
  starting_elo BIGINT UNSIGNED NOT NULL,
  feedback ENUM('WIN', 'LOSE', 'DRAW'),
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NOT NULL
    DEFAULT CURRENT_TIMESTAMP
    ON UPDATE CURRENT_TIMESTAMP,
​
  PRIMARY KEY (game_id, player_id),
​
  CONSTRAINT game_player_fk_con
    FOREIGN KEY game_player_fk(game_id)
    REFERENCES  game(id),
​
  CONSTRAINT user_player_fk_con
    FOREIGN KEY user_player_fk(player_id)
    REFERENCES  user(id)
) ENGINE=InnoDB;

