USETEXTLINKS=1
STARTALLOPEN=0
USEFRAMES=0
USEICONS=0
WRAPTEXT=1
PERSERVESTATE=1
ICONPATH="/lib/Treeview/"

foldersTree = gFld("Vyber kategorii","")
aux1 = insFld(foldersTree, gFld("Stomatologia","/go/_category/?idc=%22id_34%22"))
insDoc(aux1, gLnk("S","Cementy i podkłady","/go/_category/?idc=%2234_12084%22"))
insDoc(aux1, gLnk("S","Materiały łączące","/go/_category/?idc=%2234_12131%22"))
insDoc(aux1, gLnk("S","Profilaktyka","/go/_category/?idc=%2234_12066%22"))
aux2 = insFld(aux1, gFld("Wypełnienia","/go/_category/?idc=%2234_12063%22"))
insDoc(aux2, gLnk("S","Wypełnienia","/go/_category/?idc=%2234_12063%22"))
insDoc(aux2, gLnk("S","Amalgamaty","/go/_category/?idc=%2234_12063_15%22"))
insDoc(aux1, gLnk("S","Wyposażenie gabinetu","/go/_category/?idc=%2234_12068%22"))
insDoc(aux1, gLnk("S","Wytrawiacze","/go/_category/?idc=%2234_12070%22"))
