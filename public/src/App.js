import React from "react";
import Footer from "./components/Footer";
import Products from "./pages/Products";
import { BrowserRouter, Route, Routes } from "react-router-dom";
import AddProducts from "./pages/AddProducts";

function App() {
  return (
    <div className="d-flex flex-column min-vh-100">
      <BrowserRouter>
        <Routes>
          <Route path="/" element={<Products />} />
          <Route path="/add-product" element={<AddProducts />} />
        </Routes>
        <Footer />
      </BrowserRouter>
    </div>
  );
}

export default App;
