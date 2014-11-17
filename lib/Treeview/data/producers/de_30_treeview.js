USETEXTLINKS=1
STARTALLOPEN=0
USEFRAMES=0
USEICONS=0
WRAPTEXT=1
PERSERVESTATE=1
ICONPATH="/lib/Treeview/"

foldersTree = gFld("Kategorie wählen","")
aux1 = insFld(foldersTree, gFld("Protetyka","/go/_category/?idc=%22id_32%22"))
insDoc(aux1, gLnk("S","Akcesoria do porcelany","/go/_category/?idc=%2232_12130%22"))
aux2 = insFld(aux1, gFld("Budowa modeli","/go/_category/?idc=%2232_12065%22"))
insDoc(aux2, gLnk("S","Kleje","/go/_category/?idc=%2232_12065_66%22"))
insDoc(aux2, gLnk("S","Piny protetyczne","/go/_category/?idc=%2232_12065_31%22"))
insDoc(aux2, gLnk("S","Preparaty do gipsu i wosku","/go/_category/?idc=%2232_12065_20%22"))
insDoc(aux1, gLnk("S","Lakiery dystansowe","/go/_category/?idc=%2232_12124%22"))
insDoc(aux1, gLnk("S","Urz±dzenia","/go/_category/?idc=%2232_12107%22"))
aux2 = insFld(aux1, gFld("Woski","/go/_category/?idc=%2232_12081%22"))
insDoc(aux2, gLnk("S","Woski do modelowania","/go/_category/?idc=%2232_12081_43%22"))
insDoc(aux2, gLnk("S","Woski na protezy szkieletowe","/go/_category/?idc=%2232_12081_46%22"))
