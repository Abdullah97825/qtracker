#include <stdio.h>
#include <stdlib.h>
#include <time.h>
#include <math.h>

typedef struct myPatient{
	int patient_id;
	int arrival_time;
	int service_time;
	int departure_time;
	int waiting_time; //estimated waiting time
	int time_service_begins;
	int timeInSystem; //system response time
	
	
}Patient; //Patient

Patient *Queue; //ArrayList<Patient> patients

//static variables in QTracker2 class
int n; //target maximum number of jobs
int L; // instantaneous number of jobs in system at time t
int c; //number of servers. 1 in M/M/1
int patientCounter; //total number of patients through the system (served + in_service + in_queue) 
int leastDepatureIndex;
int next; //dequeuing index
int backupL;
Patient *Served; //holds Patients objects that have left the system
int servedIndex;
Patient *System; //holds the system. inQueue + inService.
int *inter_arrival_time; //to hold inter arrival times for the patients. is exponentially distributed?
int *idleTimes; //array to hold idletimes for calculating utilisation.

Patient *relocated; //array to hold patients relocated to this Doctor object

//performance measures for the whole simulation run at a given time, t.
float averageWaitingTime;
float averageWTforWaiting;
float utilisation;
float meanQueueLength;
float throughput;
float responseTime;
float prob30mins; //probability of waiting > 30 minutes

void enQueue(Patient newPatient )
{
	//add new patient to the end of the queue.
	Queue[patientCounter] = newPatient;	
	patientCounter++;
}

void deQueue()
{
	int i;

	Served = (Patient*) realloc (Served, sizeof(Patient)* (servedIndex+1)); //resize the Served array
	Served[servedIndex] = Queue[0]; //add patient to the served array.
	servedIndex++; //increment servedIndex. 
	
	//shift up by one.
	for(i = 0 ; i < patientCounter ; i++)
	{
		Queue[i] = Queue[i+1]; 
	}
	patientCounter--; //decremement number of patients in the system
}

void calculator(int patientIndex)
{
	//Queue array
	
	//patientIndex = 1+1 (at first)
	
	if ( Queue[patientIndex].arrival_time > Queue[patientIndex - 1].departure_time)
	{
		idleTimes[patientIndex] = Queue[patientIndex].arrival_time - Queue[patientIndex - 1].departure_time;
		
		Queue[patientIndex].time_service_begins = Queue[patientIndex].arrival_time;
		Queue[patientIndex].waiting_time = 0;
		Queue[patientIndex].departure_time = Queue[patientIndex].time_service_begins + Queue[patientIndex].service_time;
		Queue[patientIndex].timeInSystem = Queue[patientIndex].service_time;
	}
	else
	{
		Queue[patientIndex].time_service_begins = Queue[patientIndex - 1].departure_time;
		Queue[patientIndex].waiting_time = Queue[patientIndex].time_service_begins - Queue[patientIndex].arrival_time;
		Queue[patientIndex].departure_time = Queue[patientIndex].time_service_begins + Queue[patientIndex].service_time;
		Queue[patientIndex].timeInSystem = Queue[patientIndex].departure_time - Queue[patientIndex].arrival_time;
	}
	
}

void performanceMeasures()
{
	int i;
	int sum = 0, count = 0;
	float lambda, mu; printf("\npatientCounter : %d\n",patientCounter);
	
	//average waiting time
	for (i = 1; i <= patientCounter; i++)
	{
		sum = sum + Queue[i].waiting_time;
	}
	
	averageWaitingTime = (float)sum / (float)patientCounter;
	printf("\naverage waiting time : %.4f\n", averageWaitingTime);
	
	sum = 0;
	//average waiting time of those who wait
	for ( i = 1; i <= patientCounter; i++)
	{
		if (Queue[i].waiting_time != 0)
		{
			sum = sum + Queue[i].waiting_time; count = count + 1;
		}
	} 
	
	averageWTforWaiting = (float)sum / (float)count;
	printf("average waiting time of those who wait: %.4f\n", averageWTforWaiting);
	
	sum = 0;
	//utilisation = 1 - Po = 1 - (sum of idleTimes / total simulation time)
	for (i = 1; i <= patientCounter; i++) //service rate
	{
		sum = sum + idleTimes[i];
	} 
	utilisation = (float)1 - (float) sum / (float) Queue[patientCounter].departure_time;
	printf("utilisation: %.5f\n", utilisation);
	
		sum = 0;
	//mean queue length
	for (i = 1; i <= patientCounter; i++)
	{
		sum = sum + Queue[i].timeInSystem;
	} meanQueueLength = (float)sum / (float)Queue[patientCounter].departure_time;
	
	printf("mean queue length: %.4f\n", meanQueueLength);
	
		sum = 0;
	//response time (delay)
	for (i = 1; i <= patientCounter; i++)
	{
		sum = sum + Queue[i].timeInSystem;
	} responseTime = (float)sum / (float)patientCounter;
	
	printf("response time: %.4f\n", responseTime);
	
		sum = 0;
	//throughput
	throughput = (float)meanQueueLength / (float)responseTime;
	printf("throughput: %.5f\n", throughput);
	
	//probability that you will wait > 30 minutes
	int minCounter = 0;
	for (i = 1; i <= patientCounter; i++){
		if (Queue[i].waiting_time >= 30)
			minCounter++;
	}	
	prob30mins = (float)minCounter / (float)patientCounter;
	printf("probability that you will wait > 30 minutes: %.5f\n", prob30mins);
}

void printServed()
{
	int i;
	printf("\nServed:");
	printf("\nPID	Arrival time	Service time	Departure time	Waiting time	TSB	Time In System\n");
	for(i = 0; i < servedIndex; i++)
	{
		printf("%d	%d		%d		%d		%d		%d	%d\n",Served[i].patient_id, Served[i].arrival_time, Served[i].service_time, 
			Served[i].departure_time, Served[i].waiting_time, Served[i].time_service_begins, Served[i].timeInSystem );
		
	}	
	
}//



int main(void)
{	
	c = 1; //M/M/1 queuing model
	printf("\nc : 1\n");
	Queue = (Patient*) calloc ((25),sizeof (Patient) );
	Served = (Patient*) malloc (25 * sizeof(Patient)); servedIndex = 1;
	idleTimes = (int*) calloc ((n + 1), sizeof (int) );
	
	System = (Patient*) calloc (25 ,sizeof (Patient) );
		
	/*change structure to: receive file, check if arrival or departure
		if arrival - assign arrival time and service time of the last patient, calculate pms.
		else if departure - calculate pms of the queue.*/
		
	FILE *myFile, *out_file /*to queue.txt*/, *served_file /*to served.txt*/, *myServedFile;
    myFile = fopen("input.txt", "r"); out_file = fopen("queue.txt", "w"); //served_file = fopen("served.txt", "w"); 
	myServedFile = fopen("served.txt", "r+");
    
    if (myFile == NULL)
    	printf("could not open input file!\n");
    else if (myFile != NULL)
    	printf("opened input file!\n");

	if (myServedFile == NULL)
    	printf("could not open served file!\n");
    else if (myServedFile != NULL)
    	printf("opened served file!\n");
    	
    //read from queue file into array
	int i = 0; 

    while ( fscanf(myFile, "%d %d %d %d %d %d %d", &Queue[i].patient_id, &Queue[i].arrival_time, &Queue[i].service_time, 
		&Queue[i].departure_time, &Queue[i].waiting_time, &Queue[i].time_service_begins, &Queue[i].timeInSystem ) != EOF)
    {	
    	i++;
    	
        fscanf(myFile, "%d %d %d %d %d %d %d", &Queue[i].patient_id, &Queue[i].arrival_time, &Queue[i].service_time, 
		&Queue[i].departure_time, &Queue[i].waiting_time, &Queue[i].time_service_begins, &Queue[i].timeInSystem ); 
		
		++i; //to track number of records.
    }//end read queue
    
    patientCounter = i - 1; printf ("patientCounter: %d \n", patientCounter);
    
    //read in from served.txt
		  	int j = 0;
		  	while ( fscanf(myServedFile, "%d %d %d %d %d %d %d", &Served[j].patient_id, &Served[j].arrival_time, &Served[j].service_time, 
				&Served[j].departure_time, &Served[j].waiting_time, &Served[j].time_service_begins, &Served[j].timeInSystem ) != EOF)
		    {	
		    	j++;
		    	
		        fscanf(myServedFile, "%d %d %d %d %d %d %d", &Served[j].patient_id, &Served[j].arrival_time, &Served[j].service_time, 
				&Served[j].departure_time, &Served[j].waiting_time, &Served[j].time_service_begins, &Served[j].timeInSystem ); 
				
				++j; //to track number of records.
		    }//end read queue
		    
		    servedIndex = j - 1; printf ("servedIndex: %d \n", servedIndex);
		    
		    printServed();	    
    
	//print queue
    printf("Queue array received: patientCounter: %d\n", patientCounter);

	printf("\nP_ID	Arrival time	Service time	Departure time	Waiting time	TSB	Time In System\n");
	for(i = 0; i < patientCounter; i++)
	{
		printf("%d	%d		%d		%d		%d		%d	%d\n", Queue[i].patient_id, Queue[i].arrival_time, Queue[i].service_time, 
		Queue[i].departure_time, Queue[i].waiting_time, Queue[i].time_service_begins, Queue[i].timeInSystem );		
	}//end print queue.
	
	//generate event
	int eventCounter = 0, event = 1 /*+ rand()%2*/, interarrival = 0, service_time = 0;
	
		if (event == 1){ //arrival
		srand(time(NULL));
		interarrival = rand()%15, service_time = 1 + rand()%15;
		printf ("interarrival: %d, service_time: %d.\n", interarrival, service_time);
		
		//create Patient
		Patient newPatient; 		
		
		if (patientCounter != 0) // assign id
			newPatient.patient_id = Queue[patientCounter - 1].patient_id + 1; 
			
			//assign at and st;
			newPatient.service_time = service_time;
		
		if (newPatient.patient_id == 1 ){ //first packet.
			newPatient.arrival_time = 0;
			newPatient.time_service_begins = newPatient.arrival_time;			
			newPatient.departure_time = newPatient.time_service_begins + newPatient.service_time;
			newPatient.timeInSystem = newPatient.departure_time - newPatient.arrival_time;
		  }
		  else if (newPatient.patient_id > 1 && patientCounter == 0){ //not first packet but free server.
		  	//get last_arrival from Served.
		  	newPatient.arrival_time = Served[j].arrival_time + interarrival;		  	
		  	newPatient.time_service_begins = newPatient.arrival_time;			
			newPatient.departure_time = newPatient.time_service_begins + newPatient.service_time;
			newPatient.timeInSystem = newPatient.departure_time - newPatient.arrival_time;
		  }
		  else { //no free server
		  	newPatient.arrival_time = Queue[patientCounter - 1].arrival_time + interarrival;
		  	newPatient.time_service_begins = 0; newPatient.departure_time = 0;
			newPatient.timeInSystem = 0;
		  }
		  
		  enQueue(newPatient);		  
		  
		}//end arrival
		else { //departure
			deQueue();
		}
		
		//recalculate PMs.
		for (i = 0; i < patientCounter; i++){
			calculator(i);
		}
		
		//served_file = fopen("served.txt", "w");
		//if event != departure, a patient left. write to served.txt.
		if (event != 1){
			for(i = 1; i < servedIndex; i++)
			{
				fprintf(myServedFile, "%d		%d		%d		%d		%d		%d	%d\n", Served[i].patient_id, Served[i].arrival_time, Served[i].service_time, 
					Served[i].departure_time, Served[i].waiting_time, Served[i].time_service_begins, Served[i].timeInSystem );		
			}	
		}
		
		
		//print Queue
		printf ("\n============\n");
	
		printf("Queue:\n");
		
		printf("\nP_ID	Arrival time	Service time	Departure time	Waiting time	TSB	Time In System\n");
		for(i = 0; i < patientCounter; i++)
		{
			printf("%d	%d		%d		%d		%d		%d	%d\n", Queue[i].patient_id, Queue[i].arrival_time, Queue[i].service_time, 
				Queue[i].departure_time, Queue[i].waiting_time, Queue[i].time_service_begins, Queue[i].timeInSystem );
			fprintf(out_file, "%d		%d		%d		%d		%d		%d	%d\n", Queue[i].patient_id, Queue[i].arrival_time, Queue[i].service_time, 
				Queue[i].departure_time, Queue[i].waiting_time, Queue[i].time_service_begins, Queue[i].timeInSystem ); // write to queue.txt file
		}
		printf("\n============\n");
		
		printServed();
		
	//performanceMeasures(); //calculates performance measures for the whole system
	
	 	
	return 0;
}
