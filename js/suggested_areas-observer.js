class Table{
    constructor(){
        this.observers = [];
    }

    click_row(element){
        this.notifyAllObservers();
        element.classList.add('selected_row');
    }

    add_observers(observer){
        this.observers.push(observer);
    }

    notifyAllObservers(){
        for(var observer of this.observers){
            observer.unset();
        }
    }
}

class TableRow{
    constructor(element){
        this.element = element;
    }
    unset(){
        this.element.classList.remove('selected_row');
    }
}