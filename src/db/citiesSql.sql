CREATE TABLE wpCities (
  idCity INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  Name VARCHAR(50) NULL,
  PRIMARY KEY(idCity)
);

CREATE TABLE wpWeather (
  idWeather INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  wpCities_idCity INTEGER UNSIGNED NOT NULL,
  temp FLOAT NULL,
  description VARCHAR(50) NULL,
  date TIMESTAMP NULL,
  PRIMARY KEY(idWeather),
  INDEX Weather_FKIndex1(wpCities_idCity)
);


