

function CCategory(id, name, o_parent, def_sel) { // konstruktor
    this.id = id; // id kategorii - atrybut value w opcji listy typu select
    this.name = name; // nazwa kategorii - wy¶wietlana warto¶æ na opcji listy select
    this.o_parent = o_parent; // obiekt typu CCategory, który jest ojcem
    this.default_selected = def_sel; // flaga domy¶lnego wyboru opcji
    this.selected = def_sel; // flaga wyboru opcji
    this.children = new Array(); // tablica potomków (obiektów typu CCategory)
    this.producers = new Array(); // [niewykorzystane] tablica identyfikatorów producentów, dla której kategoria ma byæ dostêpna
    this.getDepth = getDepth; // metoda pobieraj±ca stopieñ zagnie¿d¿enia kategorii
    this.addCategoryChild = addCategoryChild; // dodaj potomka
    this.getChildSelected = getChildSelected; // zwróæ potomka, który jest wybrany
}


function getDepth() { // pobierz stopieñ zagnie¿d¿enia. Root ma 0
    if(this.o_parent == null) {
        return 0;
    }
    else {
        return 1 + this.o_parent.getDepth();
    }
}

function addCategoryChild(id, name, def_sel) { // dodaj podkategoriê
    o_child = new CCategory(id, name, this, def_sel);
    this.children.push(o_child);
    return o_child;
}

function getChildSelected(default_selected) { // zwróæ potomka, który jest wybrany; je¶li default_selected==true, to zwraca potomka, który jest domy¶lnie wybrany
    var k = 0;
    while(k < this.children.length) {
        if(default_selected == true) {
            if(this.children[k].default_selected == true)
                return this.children[k];
        }
        else {
            if(this.children[k].selected == true)
                return this.children[k];
        }
        k++;
    }
    return null;
}


/********* Inicjacja globalnych zmiennych **********/
var c_root; // korzeñ drzewa kategorii
var select_ids_arr = new Array(); // tablica kolejnych obiektów SELECT


function getTree(o_category) { // pobierz drzewo kategorii do prezentacji - fcja rekurencyjna
    s = '';
    depth = o_category.getDepth();
    var i = 0;
    if(depth >= 0) {
        for(i = 0; i < depth; i++) {
            s += '. ';
        }
    }
    s += o_category.name;
    if(o_category.selected == true)
        s += " [sel]";
    s += '\n';
    if(o_category.children.length > 0) {
        var j = 0;
        for(j = 0; j < o_category.children.length; j++) {
            s += getTree(o_category.children[j]);
        }
    }
    return s;
}


// usuñ wszystkie opcje wyboru z listy
function removeOptions(o_select) {
    while(o_select.options.length > 0)
        o_select.options[0] = null;
}

// wype³nij wstêpnie listy kategorii na podstawie struktury w c_root
function initCategoryLists (str_select_ids) { // str_select_ids: identyfikatory kolejnych selectów (string, oddzielone ¶rednikami)
    ids = new String(str_select_ids);
    var ids_arr = ids.split(";");
    var o_s;
    var i;
    var j;
    for(i = 0; i < ids_arr.length; i++) {
        o_s = document.getElementById(ids_arr[i]);
        o_s.depth = i;
        select_ids_arr.push(o_s);
        removeOptions(o_s);
        o_s.options[0] = new Option("--", 0); // wype³nij ka¿d± listê pierwsz± pozycj± pust±
        if(i == 0) {// wype³nij pierwsz± listê warto¶ciami
            for(j = 0; j < c_root.children.length; j++) {
                o_s.options[j + 1] = new Option(c_root.children[j].name, c_root.children[j].id, c_root.children[j].default_selected);
            }
        }
    }
    
    // domy¶lne rozwiniêcie kategorii - wype³nienie list na podstawie domy¶lnych wyborów
    var cat_node = c_root;
    i = 0;
    var child_node;
    while((i < select_ids_arr.length) && (cat_node != null)) {
        cat_node = getCurrentNode(select_ids_arr[i]);
        if(cat_node != null) {
            child_node = cat_node.getChildSelected(true);
            if(child_node != null) {
                for(j = 0; j < select_ids_arr[i].options.length; j++) {
                    if(select_ids_arr[i].options[j].value == child_node.id) {
                        select_ids_arr[i].selectedIndex = j;
                    }
                }
                selectCategory(select_ids_arr[i]);
            }
        }
        i++;
    }
}

function getCurrentNode(o_select) { // pobierz bie¿±cy node z drzewka na podstawie obiektu select
    var cat_node = c_root;
    if((o_select.options.length > 1) && (o_select.depth < select_ids_arr.length - 1)){
        while(cat_node.getDepth() < o_select.depth) {
            cat_node = cat_node.getChildSelected(false);
        }
        return cat_node;
    }
    return null;
}

function unselectCategory(o_select) { // wyczy¶æ wybór listy select i propaguj wyczyszczenie do list zale¿nych
    var cat_node = getCurrentNode(o_select);
    var i;
    if((o_select.options.length > 1) && (o_select.depth < select_ids_arr.length - 1)){
        
        while(cat_node != null) {
            cat_node = cat_node.getChildSelected(false);
            if(cat_node != null)
                cat_node.selected = false;
        }
        
        for(i = 0; i < select_ids_arr.length; i++) {
            if(select_ids_arr[i].depth > o_select.depth) {
                removeOptions(select_ids_arr[i]);
                select_ids_arr[i].options[0] = new Option("--", 0);
            }
        }
    }
}


function getNextSelect(o_select) { // pobierz obiekt select bezpo¶rednio zale¿ny od danego o_select
    var i;
    for(i = 0; i < select_ids_arr.length; i++) {
        if(select_ids_arr[i].depth == o_select.depth + 1) {
            return select_ids_arr[i];
        }
    }
}


// 
function selectCategory(o_select) { // obs³u¿ zdarzenie wybrania kategorii na li¶cie o_select
    var cat_node = getCurrentNode(o_select);
    unselectCategory(o_select);
    var sel_value = o_select.options[o_select.selectedIndex].value;
    var i;
    var j;
    for(i = 0; i < cat_node.children.length; i++) {
        if (sel_value == cat_node.children[i].id) {
            cat_node.children[i].selected = true;
            next_select = getNextSelect(o_select);
            for(j = 0; j < cat_node.children[i].children.length; j++) {
                next_select.options[j + 1] = new Option(cat_node.children[i].children[j].name, cat_node.children[i].children[j].id, cat_node.children[i].children[j].selected);
            }
        }
    }
}


function initCategories(str_select_ids) { // inicjuj modu³
    initTree(); // inicjuj drzewo obiektów klasy CCategory
    initCategoryLists(str_select_ids); // inicjuj listy 
}
