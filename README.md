### TitoR2

Integraatiotestit https://github.com/buumi/TitoR2_jarjestelmatestit

### Käyttöohje
Lyhyt yksinkertaistava ohje Git-ohjelmalle. Githubilla on myös rajoittunut verkkokäyttöliittymä jota voi käyttää Gitin sijaan.  

#### Aloitus
Asenna Git  
Lataa tämä repository: `git clone https://github.com/buumi/TitoR2.git`  

#### Normaali "workflow"
`git pull` - päivittää oman versiosi muiden välissä tekemillä muokkauksilla  
Muokkaa tiedostoja omassa suosikkieditorissa, esim PHPStorm  
Kun tiedosto valmis julkaistavaksi, aja  
`git add <muokatun_tiedoston_nimi>` - lisää tiedoston seuraavaan committiin  
`git commit` kysyy commitin kuvauksen ja commitoi paikallisesti valitut muutokset, ns. "palautuspiste"  
`git push` puskee oman uusimman "palautuspisteen" githubiin  


#### Muita hyödyllisiä komentoja  
`git log` - Näyttää viimeaikaiset commitit ja niiden kuvaukset ja tekijät  
`git diff` - Näyttää edellisen palautuspisteen ja muokattujen tiedostojen välisen eron  
`git status` - Näyttää mitä tiedostoja olet muokannut ja mitkä olet laittanut seuraavaan committiin `git add` komennolla  
