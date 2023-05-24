// data
// objet orders
let orders = [];

const fetchOrders = async () => {
  orders = await fetch(
      "http://127.0.0.1/ventalis/api/cdeCreeeLire.php"
  ).then((res) => res.json());
  console.log(orders);
};

fetchOrders();

