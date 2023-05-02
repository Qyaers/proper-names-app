const fileSelector = document.querySelector('.file-selector-input');
const fileSelectorArea = document.querySelector('.file-selector');
const output = document.querySelector('.output');

fileSelector.addEventListener('change', () => {

	let reader = new FileReader();
	reader.readAsText(fileSelector.files[0]);

	reader.onload = function () {
		console.log(reader.result);
	};
	reader.error = function () {
		console.log("Error " + reader.error);
	}
});

fileSelectorArea.addEventListener('dragover', (event) => {
	event.stopPropagation();
	event.preventDefault();
});

fileSelectorArea.addEventListener('drop', async (event) => {
	event.stopPropagation();
	event.preventDefault();
	let data = await getDataFromUploadFile(event);
	console.log(data);
});


function getDataFromUploadFile(event) {
	return new Promise(resovle => {

		let file = event.dataTransfer.files[0];
		let fileType = file.name.split(".")[1].toLowerCase();
		let reader = new FileReader();

		switch (fileType) {
			case 'xlsx':
				reader.onload = () => {
					let arrayBuffer = reader.result,
						array = new Uint8Array(arrayBuffer),
						binaryString = String.fromCharCode.apply(null, array);
					/* Call XLSX */
					let workbook = XLSX.read(binaryString, {
						type: "binary"
					});

					/* DO SOMETHING WITH workbook HERE */
					let first_sheet_name = workbook.SheetNames[0];
					/* Get worksheet */
					let worksheet = workbook.Sheets[first_sheet_name];
					const resultObj = XLSX.utils.sheet_to_json(worksheet, {
						raw: true
					});
					console.log(resultObj);

					resovle(resultObj);
				};
				reader.error = () => {
					console.log("Error " + reader.error);
				}

				reader.readAsArrayBuffer(file);
				break;

			// TODO Допиилить проверку на ввод данных, сделать из них объекты как с экселькой ( должен быть массив объектов с параметрами)
			case 'csv':
				reader.readAsText(file);
				reader.onload = () => {
					let readerResult = reader.result.split(/\r\n|;\r\n/g);
					readerResult.shift();
					const resultObj = readerResult.map(e => ({ id: e.split(";")[0], name: e.split(";")[1], ancestor: e.split(";")[2] }))
					console.log(resultObj);

					resovle(resultObj);
				};

				reader.error = () => {
					console.log("Error " + reader.error);
				}
				break;

			// TODO Допиилить проверку на ввод данных, сделать из них объекты как с экселькой ( должен быть массив объектов с параметрами)
			case 'txt':
				reader.readAsText(file);
				reader.onload = () => {
					let readerResult = reader.result.split(/\r\n|;\r\n/g);
					readerResult.shift();
					const resultObj = readerResult.map(e => ({ id: e.split(";")[0], name: e.split(";")[1], ancestor: e.split(";")[2] }))
					console.log(resultObj);

					resovle(resultObj);
				};

				reader.error = () => {
					console.log("Error " + reader.error);
				}
				break;
		}
	})
};

// TODO request add files into DB function must send data from file to server with info of data in file
async function dataSend() {

}