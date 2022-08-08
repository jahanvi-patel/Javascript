
// Add an event listener to button2
document.getElementById('button2').addEventListener('click', getJson);

// Function to get json data from a local JSON file
function getJson() {
  fetch('https://dummyjson.com/posts')
      .then(res => res.json())
      .then(data => {
        console.log(data);

        // Displaying to the UI
        let output = '';
        var string1 = JSON.stringify(data);

        var parsed = JSON.parse(string1);  
        // data = JSON.parse(data);
        data.posts.forEach(function(posts) {
          output +=`<li> id ${posts.id} 
          title ${posts.title} </li><button id="cmnt${posts.id}" class="button-primary" onclick="getJson1()">show comment</button><div id="output${posts.id}"></div>
          `
        });
        document.getElementById('output').innerHTML = output;
      })
      .catch(err => {
        console.log(err);

        // Displaying to the UI
        document.getElementById('output').innerHTML = err;
      });
}
// document.getElementByClassName('cmnt').addEventListener('click', getJson1);

// Function to get json data from a local JSON file
function getJson1() {
  fetch('https://dummyjson.com/comments')
      .then(res => res.json())
      .then(data => {
      console.log(data);

        // Displaying to the UI
        let output = '';
        let id = '';
        var string1 = JSON.stringify(data);

        var parsed = JSON.parse(string1);  
        
        data.comments.forEach(function(comments) {
          output =`<p> id ${comments.id} 
          postId ${comments.body}  </p>
          `
          id =`${comments.id}`

         
          document.getElementById('output'+id).innerHTML = output;
        });
        var reply_click = function()
{
    alert("Button clicked, id "+this.id+", text"+this.innerHTML);
}
document.getElementById('cmnt'+id).onclick = reply_click;
       //alert ( data.comments[0].id);
        
      })
      .catch(err => {
        console.log(err);

        // Displaying to the UI
        document.getElementById('output1').innerHTML = err;
      });
}

