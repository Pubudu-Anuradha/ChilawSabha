<div class="slideshow">

    <img src="" alt="slideshow" id="slideshow">

    <button  class="slideshow-btn left-btn" onclick='prev(["<?=URLROOT . "/public/assets/sabha1.jpg"?>","<?=URLROOT . "/public/assets/sabha2.jpg"?>"])'>&#10094;</button>
    <button  class="slideshow-btn right-btn" onclick='next(["<?=URLROOT . "/public/assets/sabha1.jpg"?>","<?=URLROOT . "/public/assets/sabha2.jpg"?>"])'>&#10095;</button>

</div>

<div class="container-body">
    <div class="side-menu">
        <h1></h1>
    </div>
    <div class="city">
        <h2>About City</h2>
        <div class="details">
            <p>
            Chilaw (හලාවත) is a large town in Puttalam District, North Western Province, Sri Lanka. It is governed by an urban council. The town is located 80 kilometres away from Colombo via Negombo.
            The coastal town is known for its culturally diverse background; where you can visit religious shrines and for its natural treasures, where you can embark on a bird-watching excursion through the Muthurajawela Wetlands. Chilaw offers many things to do and places to visit if you’re spending your holiday here.

            </p>
            <p>
                Munneswaram Temple <br>
                Tourists visit the well known Hindu temple located in Munneswaram, situated in the historic Demala Pattuva ("Tamil division") region of Puttalam District. The main festivals celebrated at the temple include Navarathri and Sivarathri. The former is a nine-day-long festival in honour of the presiding Goddess, while the latter is an over-night observation in honour of Lord Shiva. In addition to these two Hindu festivals, the temple observes the four-week-long Munneswaram festival which is attended by both Hindus and Buddhists. During the festival, traders sell hand-painted clay models of animals such as deer, money box tills and 'raban' (traditional hand drums) from stalls all over the town.
            </p>
            <p>
                 Our Lady of Mount Carmel Cathedral <br>
                The seat of the Chilaw Diocese, this cathedral has a history of more than two centuries. According to legend, 200 years ago, most of what is now Chilaw Town was covered by a forest. A woman was searching for firewood and heard the sound of a lady speaking, "Please take me". She stopped her work and searched for the source of the sound. A statue of Mother Mary was on a tree. The woman took the statue and handed over it to the parish priest who recognized it as Our Lady of Mount Carmel. Many believe that this same statue now stands in the cathedral. Many in Chilaw celebrate the feast of Our Lady of Mount Carmel is celebrated every July. During the feast season of Our Lady Of Mount Carmel, the town is fully decorated in homage to Mother Mary.
            </p>
            <p>
                The visit of Mahatma Gandhi <br>
                Mahathma Gandhi, the 'Father of India,' visited Chilaw in November 1927 on his first and only journey to Sri Lanka when it was called Ceylon. This was a historic visit - Gandhi was invited to Chilaw by the freedom fighters Charles Edgar Corea and his brother Victor Corea[4] who lived in the town. The brothers founded the Chilaw Association and the Ceylon National Congress and campaigned hard for the independence of Ceylon. The Corea family have had a strong link with Chilaw. There is a saying in Sri Lanka that Chilaw is well known for the three 'C's' - crabs, coconuts and Coreas.
            </p>
        </div>
    </div>

</div>

    <!-- Function to load slideshow -->
    <script>

      let index = 0;

      function slideshow(images) {
          const image = document.getElementById("slideshow");
          image.src = images[index];
          setInterval( function() {
            index = (index + 1) % images.length;
            image.src = images[index];
          }, 4000);
      }

      function next(images){
        const image = document.getElementById("slideshow");
        index = (index + 1) % images.length;
        image.src = images[index];

      }

      function prev(images){
        const image = document.getElementById("slideshow");
        index =(images.length + (index - 1)) % images.length;
        image.src = images[index];
      }

      slideshow(["<?=URLROOT . "/public/assets/sabha1.jpg"?>","<?=URLROOT . "/public/assets/sabha2.jpg"?>"]);

    </script>