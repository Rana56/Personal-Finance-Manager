//Script checks if remove button for expense pressed
$(document).ready(function(){
    //click event handler for class - listens for clicks on buttons
    $(".remove-expense").click(function() {
        var expenseID = $(this).data("expense-id");
    
        //AJAX request to remove row from database and update table
        $.ajax({
            url: "php/financeRemoveData.php", 
            method: "POST",
            data: {expense_id: expenseID},
            success: function(reponse) {
                alert("Expense Deleted");
                document.getElementById("expense-table").innerHTML = reponse;
            }, 
            error: function(){
                alert("Error Removing Expense");
            }
        });

    });

    $(".remove-income").click(function() {
        var incomeID = $(this).data("income-id");
    
        //AJAX request to remove row from database and update table
        $.ajax({
            url: "php/financeRemoveData.php", 
            method: "POST",
            data: {income_id: incomeID},
            success: function(reponse) {
                alert("Income Deleted");
                document.getElementById("income-table").innerHTML = reponse;
            }, 
            error: function(){
                alert("Error Removing Income");
            }
        });
        
    });
});