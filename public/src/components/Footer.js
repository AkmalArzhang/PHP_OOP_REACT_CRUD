import React from "react";

const Footer = () => {
  const date = new Date();
  return (
    <footer className="page-footer bg-light mt-auto py-3 text-center">
      <span>
        &copy; {date.getFullYear()}, Akmal Arzhang , Scandiweb test assignment
      </span>
    </footer>
  );
};

export default Footer;
