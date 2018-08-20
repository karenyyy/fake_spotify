
CREATE TABLE users
(
  id         INT AUTO_INCREMENT
  PRIMARY KEY,
  username   VARCHAR(25)  NOT NULL,
  firstName  VARCHAR(50)  NOT NULL,
  lastName   VARCHAR(50)  NOT NULL,
  email      VARCHAR(200) NOT NULL,
  password   VARCHAR(32)  NOT NULL,
  signUpDate DATETIME     NOT NULL,
  profilePic VARCHAR(500) NOT NULL
)
  ENGINE = InnoDB;


CREATE TABLE artists
(
  id   INT AUTO_INCREMENT
  PRIMARY KEY,
  name VARCHAR(50) NOT NULL
)
  ENGINE = InnoDB;



CREATE TABLE albums
(
  id          INT   AUTO_INCREMENT PRIMARY KEY,
  title       VARCHAR(250) NOT NULL,
  artist      INT          NOT NULL,
  artworkPath VARCHAR(500) NOT NULL,
  userid      INT          NOT NULL,
  CONSTRAINT albums_users_fk
  FOREIGN KEY (userid) REFERENCES users (id)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  CONSTRAINT albums_artists_fk
  FOREIGN KEY (artist) REFERENCES artists (id)
  ON UPDATE CASCADE
  ON DELETE CASCADE
)
  ENGINE = InnoDB;

CREATE INDEX albums_users_fk
  ON albums (userid);


CREATE TABLE Songs
(
  id       INT AUTO_INCREMENT
  PRIMARY KEY,
  title    VARCHAR(250) NOT NULL,
  artist   INT          NOT NULL,
  album    INT          NOT NULL,
  duration VARCHAR(8)   NOT NULL,
  path     VARCHAR(500) NOT NULL,
  CONSTRAINT songs_albums_fk
  FOREIGN KEY (album) REFERENCES albums (id)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  CONSTRAINT songs_artists_fk
  FOREIGN KEY (artist) REFERENCES artists (id)
    ON UPDATE CASCADE
    ON DELETE CASCADE
)
  ENGINE = InnoDB;




CREATE TABLE playlists
(
  id          INT AUTO_INCREMENT
  PRIMARY KEY,
  name        VARCHAR(50) NOT NULL,
  owner       VARCHAR(50) NOT NULL,
  dateCreated DATETIME    NOT NULL
)
  ENGINE = InnoDB;



CREATE TABLE playlistSongs
(
  id            INT AUTO_INCREMENT
  PRIMARY KEY,
  songId        INT NOT NULL,
  playlistId    INT NOT NULL,
  playlistOrder INT NOT NULL
)
  ENGINE = InnoDB;



CREATE TABLE youtubeMv
(
  id     INT AUTO_INCREMENT
  PRIMARY KEY,
  songid INT          NOT NULL,
  url    VARCHAR(100) NOT NULL,
  CONSTRAINT youtubemv_song_fk
  FOREIGN KEY (songid) REFERENCES Songs (id)
    ON UPDATE CASCADE
    ON DELETE CASCADE
)
  ENGINE = InnoDB;

CREATE INDEX youtubemv_song_fk
  ON youtubeMv (songid);

