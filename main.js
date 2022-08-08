// Function to get json data from a local JSON file
var posts, users;
function getJson() {
Promise.all([
	fetch('https://dummyjson.com/posts'),
	fetch('https://dummyjson.com/comments')
]).then(function (responses) {
	// Get a JSON object from each of the responses
	return Promise.all(responses.map(function (response) {
		return response.json();
	}));
}).then(function (data) {
	
	console.log(data);
    posts = data[0].posts;
    users = data[1].comments;
    console.log(posts);
    console.log(users);
    let output = '';
        var string1 = JSON.stringify(posts);

        var parsed = JSON.parse(string1);  

        posts.forEach(function(posts) {
          output +=`<li id="posphidden-post${posts.id}"> id ${posts.id} 
          title ${posts.title} </li><button id="${posts.id}" class="button-primary" onclick="showComment(this.id)">show comment</button><button type="button" id="hidden-post${posts.id}" onclick="hidepost(this.id)">Hide Post</button><button id="hidden-cmnt${posts.id}"  type="button" onclick="hidecmnt(this.id)">Hide Comment</button><div id="output${posts.id}"></div>
          `
        });
   
        document.getElementById('output').innerHTML = output;
        
}).catch(function (error) {
	console.log(error);
});
}


function showComment(clicked){
    let id = '';
    id = clicked - 1;
    // console.log(id);
   document.getElementById('output'+clicked).innerHTML = users[id].body;
   document.getElementById('output'+clicked).style.display = "block";
}


if(localStorage.getItem('post_btn_id')){
    var post_btn_id = JSON.parse(localStorage.getItem('post_btn_id'));
    var widget = document.getElementById("widget");
widget.innerHTML = '<button id="clear_btn">clear button</button>';
// var w_btn = document.getElementById("clear_btn");
// w_btn.addEventListener("click",
//     function() {
//         window.localStorage.clear();
//         location.reload(true);
//     }
// );

}
else{
    var post_btn_id = [];
}
class Example {
    constructor(id) {
      this.id = id;
      this.method2();
    }
    method1() {
        window.localStorage.clear();
          location.reload(true);
    }
  
    method2() {
      document.getElementById("clear_btn").onclick = this.method1;
    }
  
  }
  
  new Example('clear');
function hidepost(clicked) {
    var div1 = document.getElementById('posp'+clicked);
    console.log(div1);
    var x =localStorage.getItem('post-btn-clicked');
    const clicked1 = localStorage.getItem('post-btn-clicked'); // if this is not set it will return null
    if (clicked1 == "true") {
    if (div1.style.display !== 'none' ) {
        div1.style.display = 'none';
    }
 
    } else {
    
        post_btn_id.push('posp'+clicked);

        localStorage.setItem('post_btn_id', JSON.stringify(post_btn_id)); 
        console.log(post_btn_id);
        div1.style.display = 'none'; 
        var storedNames = localStorage.getItem("post_btn_id");
        console.log(storedNames);
        } 

};
function hidecmnt(clicked) {
    var x = clicked.slice(-1);
   
    var div = document.getElementById('output'+x);
    const clicked1 = localStorage.getItem('img-btn-clicked'); // if this is not set it will return null
//   if (clicked1) {
    if (div.style.display !== 'none') {
        div.style.display = 'none';
    // }

} else {

  localStorage.setItem('img-btn-clicked', 'true'); 
  div.style.display = 'none'; 
  } 
};


const storedNames1 = JSON.parse(localStorage.getItem('post_btn_id'));

console.log(storedNames1 );
for (let i = 0; i < storedNames1.length; i++) {
    
   setTimeout(() => {  document.getElementById(storedNames1[i]).style.display = "none"; }, 1000);
}
 

