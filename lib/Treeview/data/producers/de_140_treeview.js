USETEXTLINKS=1
STARTALLOPEN=0
USEFRAMES=0
USEICONS=0
WRAPTEXT=1
PERSERVESTATE=1
ICONPATH="/lib/Treeview/"

foldersTree = gFld("Kategorie wählen","")
aux1 = insFld(foldersTree, gFld("Ortodoncja","/go/_category/?idc=%22id_54%22"))
aux1 = insFld(foldersTree, gFld("Protetyka","/go/_category/?idc=%22id_50%22"))
aux2 = insFld(aux1, gFld("Akryle","/go/_category/?idc=%2250_12270%22"))
insDoc(aux2, gLnk("S","Duracrol","/go/_category/?idc=%2250_12270_287%22"))
insDoc(aux2, gLnk("S","Duracryl","/go/_category/?idc=%2250_12270_288%22"))
insDoc(aux2, gLnk("S","Superacryl","/go/_category/?idc=%2250_12270_289%22"))
aux2 = insFld(aux1, gFld("Akryle do licowania","/go/_category/?idc=%2250_12332%22"))
insDoc(aux2, gLnk("S","Duracryl","/go/_category/?idc=%2250_12332_288%22"))
insDoc(aux2, gLnk("S","Superpont","/go/_category/?idc=%2250_12332_298%22"))
insDoc(aux1, gLnk("S","Lakier pokrywajacy","/go/_category/?idc=%2250_12356%22"))
aux1 = insFld(foldersTree, gFld("Stomatologia","/go/_category/?idc=%22id_51%22"))
insDoc(aux1, gLnk("S","Cementy i podk³ady","/go/_category/?idc=%2251_12278%22"))
insDoc(aux1, gLnk("S","Preparaty do dzi±se³ i zêbodo³ów","/go/_category/?idc=%2251_12303%22"))
