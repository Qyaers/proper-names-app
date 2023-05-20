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

		let file, fileType, reader;
		switch (document.title) {
			case "Добавить новую категорию":
				file = fileSelectorInput.files[0];
				fileType = file.name.split(".")[1].toLowerCase();
				reader = new FileReader();
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
				break;


			// TODO Вставка идентификатора пользователя в объект пока её нету
			case "Добавить новое имя собственное":
				file = fileSelectorInput.files[0];
				fileType = file.name.split(".")[1].toLowerCase();
				reader = new FileReader();
				if (fileType = 'txt') {
					reader.readAsText(file);
					reader.onload = () => {
						let readerResult = reader.result.split(/\r\n|;\r\n/g);
						readerResult.shift();
						const resultObj = readerResult.map(e => ({ name: e.split(";")[0], description: e.split(";")[1], category: e.split(";")[2] }))
						console.log(resultObj);
						resovle(resultObj);
					};
				}
				break;
		}
	})
};

function getDataFromUploadFile(event) {
	return new Promise(resovle => {
		let file, fileType, reader;
		switch (document.title) {
			case "Добавить новую категорию":
				file = event.dataTransfer.files[0];
				fileType = file.name.split(".")[1].toLowerCase();
				reader = new FileReader();
				if (fileType == 'txt') {
					reader.readAsText(file);
					reader.onload = () => {
						let readerResult = reader.result.split(/\r\n|;\r\n/g);
						readerResult.shift();
						const resultObj = readerResult.map(e => ({ id: e.split(";")[0], name: e.split(";")[1], ancestor: e.split(";")[2] }))
						resovle(resultObj);
					};
				}
				break;


			// TODO Вставка идентификатора пользователя в объект пока её нету
			case "Добавить новое имя собственное":
				file = event.dataTransfer.files[0];
				fileType = file.name.split(".")[1].toLowerCase();
				reader = new FileReader();
				if (fileType == 'txt') {
					reader.readAsText(file);
					reader.onload = () => {
						let readerResult = reader.result.split(/\r\n|;\r\n/g);
						readerResult.shift();
						const resultObj = readerResult.map(e => ({ name: e.split(";")[0], description: e.split(";")[1], category: e.split(";")[2] }))
						resovle(resultObj);
					};
				}
				break;
		}
	})
};

