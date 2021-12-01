# WeatherCP
WeatherCP Module for WordPress Private Project

## Atualização dos Dados ##
Aponte um cronjob pro arquivo no diretorio /src/jobs/cron.php (Script responsavel por consultar a API do OpenWeather e gravar os resultados no banco local)
É necessário para não sobrecarregar a API nem estourar o número máximo de chamadas

## Shortcode ##
[WeatherCP city="{city}" unit="{unit}"]

## Metrics ##
'temp' -> Temperature
Documentação da API do openweather https://openweathermap.org/api para saber as cidades e metricas disponiveis

