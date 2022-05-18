import api from "./api";

const products = "/products";

const headers = {
  headers: {
    "Content-Type":
      "application/x-www-form-urlencoded; charset=UTF-8; application/json",
  },
};

const listAllProducts = async () => {
  try {
    const response = await api.get(products);

    return response;
  } catch (e) {
    return e;
  }
};

const deleteProducts = async (ids) => {
  const data = { source: ids };

  try {
    /*
      !Using POST instead of DELETE in case the server mod_security doesn't allow DELETE request
    */

    //const response = await api.post(`${products}/1`, data, headers);

    /*
      !If the server allows the DELETE request or you are in localhost use the bellow code
    */

    const response = await api.delete(products, {
      headers: headers.headers,
      data: data,
    });

    return response;
  } catch (e) {
    return e;
  }
};

const createProduct = async (objectData) => {
  try {
    const response = await api.post(products, objectData, headers);
    return response;
  } catch (e) {
    return e;
  }
};

export { listAllProducts, deleteProducts, createProduct };
