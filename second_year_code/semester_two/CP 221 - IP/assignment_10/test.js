var results = [
                { name: "Zawadi Kimani", regNo: "S001", math:78, english:85,
                    science:90 },
                { name: "Brian Ochieng", regNo: "S002", math:45, english:52,
                    science:60 },
                { name: "Nadia Salum", regNo: "S003", math:92, english:88,
                    science:95 },
                { name: "Peter Luwasa", regNo: "S004", math:33, english: 41,
                    science:38 },
                { name: "Sylvia Mhando", regNo: "S005", math:67, english: 71, 
                    science:74
                }             
            ];



let total = 0;

for (let i = 0; i <= 4; i++){

    total += results[i].math + results[i].english + results[i].science;
    let average = Math.round((total / 3) * 10)  / 10;
    results[i].average = average;             
                
}

console.log(results)