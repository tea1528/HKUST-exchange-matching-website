#!/usr/local/bin/perl
use strict;
use warnings;
use LWP::Simple;

my $url="http://studyabroad.ust.hk/outbound/programs/find-programs/detail/";
my @urllist;
my $name="page";
my $txt=".txt";
my @namelist;
for(my $i =17 ;$i<=48;$i++){
push @urllist, "$url$i";
push @namelist ,"$name$i$txt";
}

for(my $i =0 ;$i<=48-17;$i++){
my $page=get ($urllist[$i]);
getstore($urllist[$i],$namelist[$i]);
}

open(OUTcountry,">DataCountry.txt");
open(OUT, ">Dataname.txt");

for(my $i =0;$i<=48-17;$i++){
	my $ country="";
open(IN, $namelist[$i]);   
while(<IN>){
	(my $str2) = $_ =~ m{<h1 class="background-header short-title">(.*)</h1>};
	if ($str2 ne ""){
		$country=$str2;
	}
(my $str) = $_ =~ m{target="_blank">(.*)</a></h4>};
my $temp=$str;
	if ($temp ne ""){
		print OUTcountry $country;
		print OUTcountry "\n";
		print OUT $str;
		print OUT "\n";
	}
}
close (IN);
}
close(OUT);
close(OUTcountry);

open(OUT, ">Dataweb.txt");

for(my $i =0;$i<=48-17;$i++){
open(IN, $namelist[$i]);   
while(<IN>){
(my $str) = $_ =~ m{<h4><a href="(.*)" target="_blank"};
my $temp=$str;
	if ($temp ne ""){
		print OUT $str;
		print OUT "\n";
	}
}
close (IN);
}
close(OUT);



open(OUT, ">Dataprog.txt");

for(my $i =0;$i<=48-17;$i++){
open(IN, $namelist[$i]);   
while(<IN>){
(my $str) = $_ =~ m{<label>PROGRAM</label><span>(.*)</span></div>};
my $temp=$str;
	if ($temp ne ""){
		chomp($str);
		print OUT $str;
		print OUT "\n";
	}
}
close (IN);
}

close(OUT);

open(OUT, ">Datalocation.txt");

for(my $i =0;$i<=48-17;$i++){
open(IN, $namelist[$i]);   
while(<IN>){
	(my $str) = $_ =~ m{>LOCATION</label><span>(.*)</span>};
	my $temp=$str;
	if ($temp ne ""){
		print OUT $str;
		print OUT "\n";
	}
	else{
		(my $str2) = $_ =~ m{>LOCATION</label><span>(.*)\n};
		my $temp2=$str2;
		chomp($str2);
		if ($temp2 ne ""){
			$str2 =~ s/\r//g;
			chomp $str2;
		print OUT $str2;
		print OUT "\n";
	}
	}
}
close (IN);
}

close(OUT);

my $counter=0;
open(OUT, ">Dataoffer.txt");

my $times=0;
for(my $i =0;$i<=48-17;$i++){
open(IN, $namelist[$i]);   
while(<IN>){
	(my $str2)= $_ =~ m{clearfix"><label>(OFFERED BY)</label>};
	my $temp2=$str2;
	if ($temp2 eq "OFFERED BY" && $times!=0){
		for(my $j =$counter;$j<5;$j++){
		#	print OUT "N/A";
		#	print OUT "\t";
		}
		$counter=0;
		print OUT "\n";
	}
	



(my $str) = $_ =~ m{	*(.*)<br />};
my $temp=$str;
	if ($temp ne ""){
		$counter++;
		print OUT $str;
		print OUT "+";
		$times++;
	}
	}
	for(my $j =$counter;$j<5;$j++){
		}
close (IN);
}

close(OUT);

my @files = ('Dataname.txt','DataCountry.txt','Dataweb.txt','Datalocation.txt','Dataprog.txt','Dataoffer.txt');
my @fh;

#create an array of open filehandles.
@fh = map { open my $f, $_ or die "Cant open $_:$!"; $f } @files;

open my $out_file, ">databaseTable.txt" or die "can't open out_file: $!";

my $output;
do
{
    $output = '';

    foreach (@fh)
    {
        my $line = <$_>;
        if (defined $line)
        {
            #Special case: might not be a newline at the end of the file
            #add a newline if none is found.
            #$line .= "\n" if ($line !~ /\n$/);
            chomp $line;
            $line.=" \t";
            $line =~ s/\n//g;
            $output .= $line;
            chomp $output;
            $output =~ s/\n//g;
        }

    }
    $output =~ s/\n//g;
    print {$out_file} $output;
    print {$out_file} "\n";
}
while ($output ne '');