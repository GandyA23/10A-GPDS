/** Start main scope */
/**
Var: var es la forma más vieja de declarar una variable, por buenas prácticas, no se recomienda usarla.
Esta disponible en cualquier fragmento de código.

con var, es posible re-declarar una variable, si no se asigna un valor en la redeclaración, su valor no va a cambiar.
*/
var globalName = "Gandy";

if (1) {
  /** Start if scope */
  console.log(globalName);
  globalName = "Changed...";

  // Es posible re-declarar una variable con el mismo nombre, pero si no se asigna un valor, este no cambia.
  var globalName = "Changed again...";
  /** End if scope */
}

console.log(globalName);


/**
Let: let aparece desde ECMAScript 6, su principal diferencia es el scope, estas variables let sólo pueden existir dentro de un ciclo o una estructura de control, es posible usarla como variable global, pero hay que tener cuidado.

Variables que solo quiero que exista en un contexto especifico.

let nos ayudará a declarar una variable que solo existirá en un contexto específico, tampoco es posible re-declarar las variables let.
*/

// Esto generaría un error
// console.log(i);

// La variable i no existe antes de esta línea de código
let i;
// Dentro de los parentesís es un scope distinto al de las llaves
for (let i = 0; i < 10; i++) {
  /** Start for scope */
  // Generá un error, debido a que en el scope de for, todavía no existe la variable i
  // console.log(i);

  let i = 1;
  console.log(i);
  /** Start for scope */
}

// Imprimé un undefined, debido a que la variable en este contexto, no tiene un valor. 
console.log(i);

/**
const: Es necesario inicializar una constante con un valor, debido a que no es posible re-asignar un valor.

Las constantes es recomendable usarlas en:
  - Arrow Functions: El funcionamiento de una función es raro que cambie durante el tiempo de ejecución.
  - Objects: Gracias al encapsulamiento, es posible modificar los valores de las propiedades dentro del objeto.
*/

// Valor constante
// Este valor jamas va a cambiar.
const CURP = "AIEG...";

// Arrow function
const SUMA_DOS_VALORES = (a, b) => {
  return a + b;
}

// Object
const PERSONA = {
  // Es recomendable usar guión bajo como prefijo en cada propiedad
  _nombre: '',
  _apellido: '',
  get nombre() {
    return this._nombre;
  },
  get apellido() {
    return this._apellido;
  },
  set nombre(nombre) {
    this._nombre = nombre;
  },
  set apellido(apellido) {
    this._apellido = apellido;
  }
}

// No cambias directamente la instancia de persona, cambias sus atributos
PERSONA.nombre = 'Gandy Esaú';
PERSONA.apellido = 'Ávila Estrada';

console.log(CURP);
console.log(SUMA_DOS_VALORES(2, 3));
console.log(`${PERSONA.nombre} ${PERSONA.apellido}`);

/** End main scope */
