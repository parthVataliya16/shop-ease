<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous"> -->
        <title>Document</title>
    </head>
    <body>
        <style>
            .content {
                display: flex;
                justify-content: space-evenly;
            }
            table {
                font-family: arial, sans-serif;
                border-collapse: collapse;
                width: 100%;
            }

            td, th {
                border: 1px solid #dddddd;
                text-align: left;
                padding: 8px;
            }

            tr:nth-child(even) {
                background-color: #dddddd;
            }
        </style>
        <a href='http://localhost/practice/project/views/user/order.php'> View Your Order</a>

        <div class="content container">
            <table>
                <tr>
                    <td>Bill no.</td>
                    <td>4</td>
                </tr>
                <tr>
                    <td>Product name</td>
                    <td>Portronic</td>
                </tr>
                <tr>
                    <td>Quantity</td>
                    <td>1</td>
                </tr>
                <tr>
                    <td>Delivery Fees</td>
                    <td>333</td>
                </tr>
                <tr>
                    <td>Price</td>
                    <td>232</td>
                </tr>
                <tr>
                    <td>Discount</td>
                    <td>333</td>
                </tr>
            </table>
        </div>
    </body>
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script> -->
</html>