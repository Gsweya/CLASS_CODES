var x = 1;

console.log("With break");
while (x < 20) {
  if (x % 2 === 0) {
    console.log(x);
    break;
  }
  x++;
}

console.log("Write with Continue");

x = 1;
while (x < 20) {
  if (x % 2 !== 0) {
  } else {
    console.log(x);
  }
  x++;
}

/*
factorials
*/

function factorial(x) {
  if (x <= 0) {
    return 1;
  } else {
    return x * factorial(x - 1);
  }
}
