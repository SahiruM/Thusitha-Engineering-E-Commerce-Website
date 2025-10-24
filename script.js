function addToWishList(id){
    




 
    var form = new FormData();
 
    form.append("id",id);
   
   
 
    var request = new XMLHttpRequest();
 
 
 
    request.onreadystatechange = function () {
 
     if(request.readyState == 4){
 
        var response = request.responseText;
 
        
     }
    }
 
 
 
    request.open("POST" , "addToWishListProcess.php", true);
    request.send(form);
 }




 function removeItem(id){
    




 
    var form = new FormData();
 
    form.append("id",id);
   
  
 
    var request = new XMLHttpRequest();
 
 
 
    request.onreadystatechange = function () {
 
     if(request.readyState == 4){
 
        window.location.reload();
     }
    }
 
 
 
    request.open("POST" , "removeWishlistProcess.php", true);
    request.send(form);
 }



 function adProduct(){

    var pName = document.getElementById("productName").value;
    var pPrice = document.getElementById("productPrice").value;
    var pImage = document.getElementById("productImage");
    var pStock = document.getElementById("stockCount").value;
 
 
  
    var form = new FormData();
 
    form.append("pName",pName);
    form.append("pPrice",pPrice);
    form.append("image",pImage.files[0]);
    form.append("pStock",pStock);
 
 
 
    var request = new XMLHttpRequest();
 
 
 
    request.onreadystatechange = function () {
 
     if(request.readyState == 4){
 
        var response = request.responseText;
 
        if(response == "done"){
         window.location.reload();
 
        }else{
         alert(response);
        }
     }
    }
 
 
 
    request.open("POST" , "addProduct.php", true);
    request.send(form);
 }

 function adminModel(id){

    var form = new FormData();
 
    form.append("id",id);
   
  
 
    var request = new XMLHttpRequest();
 
 
 
    request.onreadystatechange = function () {
 
     if(request.readyState == 4){
 
        var response = JSON.parse(request.responseText);
        document.getElementById('editProductName').value=response.product_name;
        document.getElementById('editProductPrice').value=response.price;
        document.getElementById('editStockCount').value=response.stock;

        document.getElementById('editProductSave').addEventListener('click',function(){
            saveChanges(id);
        });


        // You can now use the response data (product details)
        console.log(response);
     }
    }
 
 
 
    request.open("POST" , "searchProduct.php", true);
    request.send(form);
      // Open modal on any edit button click
      document.querySelectorAll('.edit-btn').forEach((btn) => {
        btn.addEventListener('click', () => {
          document.getElementById('editModal').style.display = 'flex';
        });
      });
  
      
  
    //   function saveChanges() {
    //     // Add actual save logic here
    //     alert('Changes saved!');
    //     closeModal();
    //   }
 }


 function closeModal() {
    document.getElementById('editModal').style.display = 'none';
  }

     function saveChanges(id) {


        var pName = document.getElementById("editProductName").value;
        var pPrice = document.getElementById("editProductPrice").value;
        var pImage = document.getElementById("editProductImage");
        var pStock = document.getElementById("editStockCount").value;
     
  
      
        var form = new FormData();
     
        form.append("pName",pName);
        form.append("pPrice",pPrice);
        form.append("image",pImage.files[0]);
        form.append("pStock",pStock);
     
        form.append("id",id);
     
     
        var request = new XMLHttpRequest();
     
     
     
        request.onreadystatechange = function () {
     
         if(request.readyState == 4){
     
            window.location.reload();
         }
        }
     
     
     
        request.open("POST" , "updateProduct.php", true);
        request.send(form);
        // Add actual save logic here
       
        
      }


      function save_message(){


        
        var name = document.getElementById("name").value;
        var email = document.getElementById("email").value;
       
        var phone = document.getElementById("phone").value;  
        var message = document.getElementById("message").value;
  
      
        var form = new FormData();
     
        form.append("name",name);
        form.append("email",email);
       
        form.append("phone",phone);
     
        form.append("message",message);
     
     
        var request = new XMLHttpRequest();
     
     
     
        request.onreadystatechange = function () {
     
         if(request.readyState == 4){
     
            swal("success", "Your message saved", "success");
         }
        }
     
     
     
        request.open("POST" , "commentSave.php", true);
        request.send(form);
        // Add actual save logic here
       

      }


     function saveComment(){

        var message = document.getElementById("comment-input").value;
  
      
        var form = new FormData();
     
       
        form.append("message",message);
     
     
        var request = new XMLHttpRequest();
     
     
     
        request.onreadystatechange = function () {
     
         if(request.readyState == 4){
           console.log(request.responseText);
            swal("success", "Your comment saved", "success");
         }
        }
     
     
     
        request.open("POST" , "commentSave2.php", true);
        request.send(form);

      }

      function deleteComment(id){
         var form = new FormData();
     
       
         form.append("id",id);
      
      
         var request = new XMLHttpRequest();
      
      
      
         request.onreadystatechange = function () {
      
          if(request.readyState == 4){
            console.log(request.responseText);
            window.location.reload();
          }
         }
      
      
      
         request.open("POST" , "commentDelete.php", true);
         request.send(form);
      }

      function updateComment(id){
         let input = "comment"+id;
         let text = document.getElementById(input).value;
         
         let form = new FormData();
     
       
         form.append("id",id);
         form.append("text",text);
      
      
         var request = new XMLHttpRequest();
      
      
      
         request.onreadystatechange = function () {
      
          if(request.readyState == 4){
            console.log(request.responseText);
            window.location.reload();
          }
         }
      
      
      
         request.open("POST" , "commentUpdate.php", true);
         request.send(form);

      }


      function rateHeart(element, index,id) {
         const rating = element.closest('.rating');
         const hearts = rating.querySelectorAll('i');
         let value = 0;
       
         hearts.forEach((heart, i) => {
           if (i < index) {
             heart.classList.add('filled');
             value++;
           } else {
             heart.classList.remove('filled');
           }
         });

         let form = new FormData();
       
         form.append("id",id);
         form.append("value",value);
      
      
         var request = new XMLHttpRequest();
      
      
      
         request.onreadystatechange = function () {
      
          if(request.readyState == 4){
            console.log(request.responseText);
            swal("success", "Your review saved", "success");
          }
         }
      
      
      
         request.open("POST" , "addReview.php", true);
         request.send(form);


       }

       //add to cart
       function addToCart(id){
    




 
         var form = new FormData();
      
         form.append("id",id);
        
      
      
         var request = new XMLHttpRequest();
      
      
      
         request.onreadystatechange = function () {
      
          if(request.readyState == 4){
      
             var response = request.responseText;
      
              alert(response);
          }
         }
      
      
      
         request.open("POST" , "addToCartProcess.php", true);
         request.send(form);
      }
      
      
      //remove item from cart
      function remove_item (id){
      
         
         var form = new FormData();
      
         form.append("id",id);
        
      
      
         var request = new XMLHttpRequest();
      
      
      
         request.onreadystatechange = function () {
      
          if(request.readyState == 4){
      
             var response = request.responseText;
      
              if(response == "done"){
      
                  window.location.reload();
      
              }
      
              else{
      
               alert (response);
              }
          }
         }
      
      
      
         request.open("POST" , "removeCartProcess.php", true);
         request.send(form);
      }
      



   function placeOrder(){

      var name = document.getElementById("name").value;
        var shipping_address = document.getElementById("shipping_address").value;
        var email = document.getElementById("email").value;  
        var phone = document.getElementById("phone").value;
        var payment = document.getElementById("payment").value;

  
      
        var form = new FormData();
     
        form.append("name",name);
        form.append("shipping_address",shipping_address);
        form.append("email",email);
        form.append("phone",phone);
        form.append("payment",payment);
     
     
        var request = new XMLHttpRequest();
     
     
     
        request.onreadystatechange = function () {
     
         if(request.readyState == 4){
            alert("Done");
         }
        }
        
     
     
     
        request.open("POST" , "process-checkout.php", true);
        request.send(form);
        // Add actual save logic here

   }




   function toggleDropdown() {
      var dropdown = document.getElementById("dropdownMenu");
      dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";
  }

  // Optional: Close dropdown if clicked outside
  document.addEventListener("click", function(event) {
      var dropdown = document.getElementById("dropdownMenu");
      var profileImg = event.target.closest("img");
      if (!event.target.closest("#dropdownMenu") && !profileImg) {
          dropdown.style.display = "none";
      }
  });


  function Delete(id){
      
         
   var form = new FormData();

   form.append("id",id);
  


   var request = new XMLHttpRequest();



   request.onreadystatechange = function () {

    if(request.readyState == 4){

       var response = request.responseText;

        if(response == "done"){

            window.location.reload();

        }

        else{

         alert (response);
        }
    }
   }



   request.open("POST" , "deleteProduct.php", true);
   request.send(form);
}

function toggleDropdown() {
   var dropdown = document.getElementById("dropdownMenu");
   dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";
}

document.addEventListener("click", function(event) {
   var dropdown = document.getElementById("dropdownMenu");
   var profileImg = event.target.closest("img");
   if (!event.target.closest("#dropdownMenu") && !profileImg) {
       dropdown.style.display = "none";
   }
});




