import { error } from 'console';
import { text } from 'stream/consumers';

/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.{js,svelte}",
    "./resources/**/*.blade.php",
  ],
  theme: {
    extend: {},
  },
  plugins: [
    require('daisyui')
  ],
  daisyui: {
    themes: [
      { 
        dim:{
          ...require("daisyui/src/theming/themes")["dim"],
          ".btn-primary":{
            color:"#fff",
            backgroundColor:"#007aff",
            borderColor:"#007aff",
            "&:hover":{
              backgroundColor:"#005f9e",
              borderColor:"#005f9e",
            }
          },
          ".btn-secondary":{
            color:"#fff",
            backgroundColor:"#b5281b",
            borderColor:"#b5281b",
            "&:hover":{
              backgroundColor:"#9c2116",
              borderColor:"#9c2116",
            }
          },
          ".btn-info":{
            color:"#fff",
            backgroundColor:"#32b33f",
            borderColor:"#32b33f",
            "&:hover":{
              backgroundColor:"#25852f",
              borderColor:"#25852f",
            }
          },
          ".btn-warning":{
            color:"#fff",
            backgroundColor:"#cc9e1f",
            borderColor:"#cc9e1f",
            "&:hover":{
              backgroundColor:"#a88420",
              borderColor:"#a88420",
            }
          },
        }
      }
    ]
  }

  }

