// Get all the 'a' elements in the sidebar
const sidebarLinks = document.querySelectorAll('.sidebar a');
console.log(sidebarLinks)

// Loop through each 'a' element and add an event listener
sidebarLinks.forEach(link => {
  link.addEventListener('click', function(e) {
    e.preventDefault(); // Prevent the link from redirecting
    console.log("test");
    
    // Remove the 'active' class from all 'a' elements
    sidebarLinks.forEach(link => link.classList.remove('active'));
    
    this.classList.add('active');
    
    // Change the content of the webpage
    //const content = document.querySelector('#content');
    //content.innerHTML = `You clicked on ${this.textContent}`;
  });
});
  
