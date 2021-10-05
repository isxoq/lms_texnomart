export class YordamchiClass {
    lotinKril(lotin) {
      lotin = " " + lotin + " ";
  
      var kril = "";
      for (var i = 0; i < lotin.length; i++) {
        var a = lotin.charAt(i);
  
        switch (a) {
          case "A":
            kril += "А";
            break;
          case "B":
            kril += "Б";
            break;
          case "C":
            if (lotin.charAt(i + 1) == "h" || lotin.charAt(i + 1) == "H") {
              kril += "Ч";
              i++;
            }
            break;
          case "D":
            kril += "Д";
            break;
          case "E":
            if (lotin.charAt(i - 1) == " " || i == 0) {
              kril += "Э";
              break;
            } else {
              kril += "Е";
              break;
            }
          case "F":
            kril += "Ф";
            break;
          case "G":
            if (lotin.charAt(i + 1) == 39) {
              kril += "Ғ";
              i++;
            } else {
              kril += "Г";
            }
            break;
          case "H":
            kril += "Ҳ";
            break;
          case "I":
            kril += "И";
            break;
          case "J":
            kril += "Ж";
            break;
          case "K":
            kril += "К";
            break;
          case "L":
            kril += "Л";
            break;
          case "M":
            kril += "М";
            break;
          case "N":
            kril += "Н";
            break;
          case "O":
            if (lotin.charAt(i + 1) == 39) {
              kril += "Ў";
              i++;
            } else {
              kril += "О";
            }
            break;
          case "P":
            kril += "П";
            break;
          case "Q":
            kril += "Қ";
            break;
          case "R":
            kril += "Р";
            break;
          case "S":
            if (lotin.charAt(i + 1) == "h" || lotin.charAt(i + 1) == "H") {
              kril += "Ш";
              i++;
            } else {
              kril += "С";
            }
            break;
          case "T":
            kril += "Т";
            break;
          case "U":
            kril += "У";
            break;
          case "V":
            kril += "В";
            break;
          case "X":
            kril += "Х";
            break;
          case "Y":
            if (lotin.charAt(i + 1) == "u" || lotin.charAt(i + 1) == "U") {
              kril += "Ю";
              i++;
            } else {
              if (lotin.charAt(i + 1) == "a" || lotin.charAt(i + 1) == "A") {
                kril += "Я";
                i++;
              } else {
                if (lotin.charAt(i + 1) == "o" || lotin.charAt(i + 1) == "O") {
                  if (lotin.charAt(i + 2) != 39) {
                    kril += "Ё";
                    i++;
                  } else {
                    kril += "Й";
                  }
                } else {
                  kril += "Й";
                }
              }
            }
            break;
          case "Z":
            kril += "З";
            break;
          case "a":
            kril += "а";
            break;
          case "b":
            kril += "б";
            break;
          case "c":
            if (lotin.charAt(i + 1) == "h" || lotin.charAt(i + 1) == "H") {
              kril += "ч";
              i++;
            }
            break;
          case "d":
            kril += "д";
            break;
          case "e":
            if (lotin.charAt(i - 1) == " " || i == 0) {
              kril += "э";
              break;
            } else {
              kril += "е";
              break;
            }
          case "f":
            kril += "ф";
            break;
          case "g":
            if (lotin.charAt(i + 1) == 39) {
              kril += "ғ";
              i++;
            } else {
              kril += "г";
            }
            break;
          case "h":
            kril += "ҳ";
            break;
          case "i":
            kril += "и";
            break;
          case "j":
            kril += "ж";
            break;
          case "k":
            kril += "к";
            break;
          case "l":
            kril += "л";
            break;
          case "m":
            kril += "м";
            break;
          case "n":
            kril += "н";
            break;
          case "o":
            if (lotin.charAt(i + 1) == 39) {
              kril += "ў";
              i++;
            } else {
              kril += "о";
            }
            break;
          case "p":
            kril += "п";
            break;
          case "q":
            kril += "қ";
            break;
          case "r":
            kril += "р";
            break;
          case "s":
            if (lotin.charAt(i + 1) == "h" || lotin.charAt(i + 1) == "H") {
              kril += "ш";
              i++;
            } else {
              kril += "с";
            }
            break;
          case "t":
            kril += "т";
            break;
          case "u":
            kril += "у";
            break;
          case "v":
            kril += "в";
            break;
          case "x":
            kril += "х";
            break;
          case "y":
            if (lotin.charAt(i + 1) == "u" || lotin.charAt(i + 1) == "U") {
              kril += "ю";
              i++;
            } else {
              if (lotin.charAt(i + 1) == "a" || lotin.charAt(i + 1) == "A") {
                kril += "я";
                i++;
              } else {
                if (lotin.charAt(i + 1) == "o" || lotin.charAt(i + 1) == "O") {
                  if (lotin.charAt(i + 2) != 39) {
                    kril += "ё";
                    i++;
                  } else {
                    kril += "й";
                  }
                } else {
                  kril += "й";
                }
              }
            }
            break;
          case "z":
            kril += "з";
            break;
  
          default:
            kril += lotin.charAt(i);
            break;
        }
      }
  
      var newKril = "";
      for (var i = 1; i < kril.length - 1; i++) {
        newKril += kril.charAt(i);
      }
      return newKril.toString();
    }
  
    krilLotin(kril) {
      kril = " " + kril + " ";
  
      var lotin = "";
      for (var i = 0; i < kril.length; i++) {
        var a = kril.charAt(i);
  
        switch (a) {
          case "А":
            lotin += "A";
            break;
          case "Б":
            lotin += "B";
            break;
          case "В":
            lotin += "V";
            break;
          case "Г":
            lotin += "G";
            break;
          case "Д":
            lotin += "D";
            break;
          case "Е":
            lotin += "Ye";
            break;
          case "Ё":
            lotin += "Yo";
            break;
          case "Ж":
            lotin += "J";
            break;
          case "З":
            lotin += "Z";
            break;
          case "И":
            lotin += "I";
            break;
          case "Й":
            lotin += "Y";
            break;
          case "К":
            lotin += "K";
            break;
          case "Л":
            lotin += "L";
            break;
          case "М":
            lotin += "M";
            break;
          case "О":
            lotin += "O";
            break;
          case "П":
            lotin += "P";
            break;
          case "Р":
            lotin += "R";
            break;
          case "С":
            lotin += "S";
            break;
          case "Т":
            lotin += "T";
            break;
          case "У":
            lotin += "U";
            break;
          case "Ф":
            lotin += "F";
            break;
          case "Х":
            lotin += "X";
            break;
          case "Ч":
            lotin += "Ch";
            break;
          case "Ш":
            lotin += "Sh";
            break;
          case "Ъ":
            lotin += "'";
            break;
          case "Э":
            lotin += "Е";
            break;
          case "Ю":
            lotin += "Yu";
            break;
          case "Я":
            lotin += "Ya";
            break;
          case "Ў":
            lotin += "O'";
            break;
          case "Ғ":
            lotin += "G'";
            break;
          case "Қ":
            lotin += "Q";
            break;
          case "Ҳ":
            lotin += "H";
            break;
          case "а":
            lotin += "a";
            break;
          case "б":
            lotin += "b";
            break;
          case "в":
            lotin += "v";
            break;
          case "г":
            lotin += "g";
            break;
          case "д":
            lotin += "d";
            break;
          case "е":
            lotin += "ye";
            break;
          case "ё":
            lotin += "yo";
            break;
          case "ж":
            lotin += "j";
            break;
          case "з":
            lotin += "z";
            break;
          case "и":
            lotin += "i";
            break;
          case "й":
            lotin += "y";
            break;
          case "к":
            lotin += "k";
            break;
          case "л":
            lotin += "l";
            break;
          case "м":
            lotin += "m";
            break;
          case "о":
            lotin += "o";
            break;
          case "п":
            lotin += "p";
            break;
          case "р":
            lotin += "r";
            break;
          case "с":
            lotin += "s";
            break;
          case "т":
            lotin += "t";
            break;
          case "у":
            lotin += "u";
            break;
          case "ф":
            lotin += "f";
            break;
          case "х":
            lotin += "x";
            break;
          case "ч":
            lotin += "ch";
            break;
          case "ш":
            lotin += "sh";
            break;
          case "ъ":
            lotin += "'";
            break;
          case "э":
            lotin += "e";
            break;
          case "ю":
            lotin += "yu";
            break;
          case "я":
            lotin += "ya";
            break;
          case "ў":
            lotin += "o'";
            break;
          case "ғ":
            lotin += "g'";
            break;
          case "қ":
            lotin += "q";
            break;
          case "ҳ":
            lotin += "h";
            break;
          default:
            lotin += a;
            break;
        }
      }
      return lotin.toString();
    }
  }
  
  