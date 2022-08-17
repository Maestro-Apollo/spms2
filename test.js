let obj1 = { a: true };
let obj2 = obj1;

obj2.b = 'Rafi';
obj2.a = 'Refat';

delete obj1.b;

console.log(obj1);
console.log(obj2);