 const weatherIcon = {
         "Rain": "wi wi-day-rain",
         "Clouds": "wi wi-day-cloudy",
         "Clear": "wi wi-day-sunny",
         "Snow": "wi wi-day-snow",
         "Mist": "wi wi-day-fog",
         "Drizzle": "wi wi-day-sleet",
         "Clouds-high": "wi-day-cloudy-high",
      }

      function capitalize(str){
         return str[0].toUpperCase() + str.slice(1);
      }

                async function main(withIp = true){ // adresse ip de l'utilisateur

                let ville;

               if(withIp){
                 ville = await fetch('http://api.ipstack.com/ 176.159.91.31?access_key=91913480e438d4f8cb02499b9389bfe7')
                 .then(resultat => resultat.json())
                 .then(json => json.city)
                 console.log(ville);
              }else{
                ville = document.querySelector('#ville').textContent;
             }
             const meteo = await fetch(`http://api.openweathermap.org/data/2.5/weather?q=${ville}&appid=2e0e5ede742861192d75ef2771bd649e&lang=fr&units=metric`)

             .then(resultat => resultat.json())
             .then(json => json)
             console.log(meteo);
             displayWeatherInfos(meteo)
          }

          function displayWeatherInfos(data){
            const name = data.name;
            const temperature = data.main.temp;
            const conditions = data.weather[0].main;
            const description = data.weather[0].description;

            document.querySelector('#ville').textContent =name;
            document.querySelector('#temperature').textContent = Math.round(temperature);
            document.querySelector('#conditions').textContent = capitalize(description);

            document.querySelector('i.wi').className = weatherIcon[conditions];
            document.body.className = conditions.toLowerCase();
         }

         const result = document.querySelector('#ville');

         ville.addEventListener('click', () => {
          ville.contentEditable = true;
       });

         ville.addEventListener('keydown', (e) =>{
            if(e.keyCode === 13){
               e.preventDefault();
               ville.contentEditable = false;
               main(false);
            }
         })

         main();