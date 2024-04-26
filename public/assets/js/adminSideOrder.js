window.onload = () => {
    $.ajax ({
        method: 'GET',
        url: `/practice/Project/routes/web.php/v1/allOrders`,
        success: function(result) {
            console.log(result);
            if (result.status == 200) {
                result.orders.forEach((order, index) => {
                    const tableRow = document.createElement("tr");
                    document.getElementsByClassName("orders")[0].appendChild(tableRow);
                    tableRow.classList.add("orderData");

                    const userName = document.createElement("td");
                    document.getElementsByClassName("orderData")[index].appendChild(userName);
                    userName.innerHTML = order.user_name;

                    const productName = document.createElement("td");
                    document.getElementsByClassName("orderData")[index].appendChild(productName);
                    productName.innerHTML = order.product_name;

                    const quantity = document.createElement("td");
                    document.getElementsByClassName("orderData")[index].appendChild(quantity);
                    quantity.innerHTML = order.quantity;

                    const status = document.createElement("td");
                    document.getElementsByClassName("orderData")[index].appendChild(status);
                    status.classList.add("status");

                    if (order.status == 'accept' || order.status == "delivered") {
                        status.innerHTML = order.status;
                    } else {
                        const selectProductStatus = document.createElement("select");
                        document.getElementsByClassName("status")[index].appendChild(selectProductStatus);
                        selectProductStatus.classList.add("selectProductStatus");
                        
                        const orderStatuses = ['cancelled', 'waiting', 'accept', 'delivered'];
                        
                        orderStatuses.forEach(status => {
                            const orderStatus = document.createElement("option");
                            document.getElementsByClassName("selectProductStatus")[index].appendChild(orderStatus);
                            orderStatus.classList.add("orderStatus");
                            orderStatus.innerHTML = status;
                            orderStatus.setAttribute("id", status);
                            
                            if (status == order.status) {
                                orderStatus.setAttribute("selected", "");
                            }
                        });
                    }

                    const expectedDelivery = document.createElement("input");
                    document.getElementsByClassName("status")[index].appendChild(expectedDelivery);
                    expectedDelivery.setAttribute("placeholder", "Expected delivery days");

                    

                });

                $(".table").DataTable();


            }
        }
    })
}