/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./public/*.php", "./public/*.html"],
  theme: {
    extend: {
      fontFamily: {
        custom: ["Poppins", "serif"],
      },
      height: {
        200: "10rem", // Custom height of 128 (32rem)
        400: "20rem", // Custom height of 140 (35rem)
      },
    },
  },
  plugins: [],
};
