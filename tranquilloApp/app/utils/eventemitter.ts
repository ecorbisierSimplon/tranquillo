/* La classe EventEmitter<T> dans TypeScript permet de s'abonner et de déclencher des événements de
type T via des fonctions de rappel. */
export class EventEmitter<T> {
  /* La ligne `listeners: ((event: T) => void)[] = [];` dans l'extrait de code TypeScript déclare une
  propriété `listeners` dans la classe `EventEmitter`. */
  listeners: ((event: T) => void)[] = [];

  /**
   * La fonction « subscribe » dans TypeScript ajoute un rappel à une liste d'écouteurs et renvoie une
   * fonction pour supprimer ce rappel.
   * @param callback - Le paramètre `callback` dans la méthode `subscribe` est une fonction qui prend un
   * événement de type `T` comme argument et ne renvoie rien (`void`). Cette fonction est ajoutée au
   * tableau `listeners` pour être appelée chaque fois qu'un événement de type `T` se produit.
   * @returns Une fonction est renvoyée. Cette fonction renvoyée peut être utilisée pour désinscrire la
   * fonction de rappel de la liste des auditeurs.
   */
  subscribe(callback: (event: T) => void) {
    this.listeners.push(callback);
    return () => {
      let idx = this.listeners.indexOf(callback);
      if (idx >= 0) this.listeners.splice(idx, 1);
    };
  }

  /**
   * La fonction "fire" parcourt une liste d'écouteurs et appelle chaque écouteur avec un événement,
   * gérant ainsi les erreurs qui peuvent survenir.
   * @param {T} event - Le paramètre `event` dans la fonction `fire` représente l'objet événement qui est
   * transmis aux écouteurs d'événement. Lorsque la fonction `fire` est appelée, elle parcourt tous les
   * écouteurs d'événements enregistrés (`this.listeners`) et appelle chaque fonction de rappel
   * d'écouteur avec l'objet `event` comme objet
   */
  fire(event: T) {
    for (var cb of this.listeners) {
      try {
        cb(event);
      } catch {
        //ignore
      }
    }
  }
}
