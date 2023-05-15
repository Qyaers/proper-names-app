const fileSelectorInput = document.querySelector('.file-selector-input');
const fileSelectorArea = document.querySelector('.file-selector');
const addInfoBtn = document.querySelector('.add-from-file__btn');

const output = document.querySelector('.output');

let data;

fileSelectorArea.addEventListener('dragover', (event) => {
	event.stopPropagation();
	event.preventDefault();
});

fileSelectorArea.addEventListener('drop', async (event) => {
	event.stopPropagation();
	event.preventDefault();
	data = '';

	data = await getDataFromUploadFile(event);
	console.log(typeof (data));
});

fileSelectorInput.addEventListener('change', async (event) => {
	event.stopPropagation();
	event.preventDefault();
	data = '';
	data = await getDataFromUploadFileInput();

	console.log(typeof (data));
});

addInfoBtn.addEventListener('click', async () => {
	if (data) {
		const response = await fetch('?r=site/AddNewProperName', {
			method: 'POST',
			headers: {
				'Content-Type': 'application/json',
			},
			// Данные
			body: JSON.stringify(data)
		});
		let output = await response.json()
		if (output.code == 200) {
			console.log(output);
			alert("Данные успешно добавлены!\n" + JSON.stringify(output.message));
		}
		else {
			alert("Произошла ошибка");
		}

	}
	else {
		alert("Формы не заполнены, или не верный фармат файла.");
	}
});

function getDataFromUploadFileInput() {
	return new Promise(resovle => {
		let file = fileSelectorInput.files[0];
		let fileType = file.name.split(".")[1].toLowerCase();
		let reader = new FileReader();

		if (fileType = 'txt') {
			reader.readAsText(file);
			reader.onload = () => {
				let readerResult = reader.result.split(/\r\n|;\r\n/g);
				readerResult.shift();
				const resultObj = readerResult.map(e => ({ id: e.split(";")[0], name: e.split(";")[1], ancestor: e.split(";")[2] }))
				console.log(resultObj);

				resovle(resultObj);
			};
		}
	})
};

function getDataFromUploadFile(event) {
	return new Promise(resovle => {

		let file = event.dataTransfer.files[0];
		let fileType = file.name.split(".")[1].toLowerCase();
		let reader = new FileReader();
		if (fileType == 'txt') {
			// TODO Допиилить проверку на ввод данных, сделать из них объекты как с экселькой ( должен быть массив объектов с параметрами)
			reader.readAsText(file);
			reader.onload = () => {
				let readerResult = reader.result.split(/\r\n|;\r\n/g);
				readerResult.shift();
				const resultObj = readerResult.map(e => ({ id: e.split(";")[0], name: e.split(";")[1], ancestor: e.split(";")[2] }))
				resovle(resultObj);
			};
		}
	})
};

// TODO request add files into DB function must send data from file to server with info of data in file
