USETEXTLINKS=1
STARTALLOPEN=0
USEFRAMES=0
USEICONS=0
WRAPTEXT=1
PERSERVESTATE=1
ICONPATH="/lib/Treeview/"

foldersTree = gFld("Kategorie wählen","")
aux1 = insFld(foldersTree, gFld("Protetyka","/go/_category/?idc=%22id_41%22"))
insDoc(aux1, gLnk("S","Narzêdzia do modelowania","/go/_category/?idc=%2241_12180%22"))
insDoc(aux1, gLnk("S","Pi³ki,brzeszczoty","/go/_category/?idc=%2241_12204%22"))
aux2 = insFld(aux1, gFld("Woski","/go/_category/?idc=%2241_12171%22"))
insDoc(aux2, gLnk("S","Woski do modelowania","/go/_category/?idc=%2241_12171_156%22"))
insDoc(aux2, gLnk("S","Woski na protezy szkieletowe","/go/_category/?idc=%2241_12171_159%22"))
